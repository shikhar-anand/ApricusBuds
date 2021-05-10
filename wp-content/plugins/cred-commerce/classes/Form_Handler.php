<?php

/**
 * Class CRED Commerce Form Handler
 */
class CRED_Commerce_Form_Handler implements ICRED_Commerce_Form_Handler {

	protected $plugin = null;
	protected $form = null;
	protected $model;
	protected $_data = false;

	public function __construct() {
	}

	// dependency injection
	public function init( $plugin, $model ) {
		$this->model = $model;
		$this->plugin = $plugin;

		// add necessary hooks to manage the form submission
		//add_action('cred_save_data', array($this, 'onSaveData'), 10, 2);
		add_action( 'cred_submit_complete', array( $this, 'onSubmitComplete' ), 1, 2 );
		add_action( 'cred_custom_success_action', array( $this, 'onFormSuccessAction' ), 1, 4 );
		add_filter( 'cred_get_form_submit_custom_redirect_url', array( $this, 'get_redirect_url' ), 10, 2 );
		//add_action('cred_commerce_payment_complete', array($this, 'onPaymentComplete'), 1, 1 );
		$this->plugin->attach( '_cred_commerce_order_received', array( $this, 'onOrderReceived' ) );
		$this->plugin->attach( '_cred_commerce_payment_failed', array( $this, 'onPaymentFailed' ) );
		$this->plugin->attach( '_cred_commerce_payment_completed', array( $this, 'onPaymentComplete' ) );
		$this->plugin->attach( '_cred_order_status_changed', array( $this, 'onOrderChange' ) );
		$this->plugin->attach( '_cred_commerce_order_on_hold', array( $this, 'onHold' ) );
		$this->plugin->attach( '_cred_commerce_payment_refunded', array( $this, 'onRefund' ) );
		$this->plugin->attach( '_cred_commerce_payment_cancelled', array( $this, 'onCancel' ) );
		$this->plugin->attach( '_cred_order_created', array( $this, 'onOrderCreated' ) );
		$this->plugin->attach( '_cred_commerce_order_completed', array( $this, 'onOrderComplete' ) );
	}

	/**
	 * @return mixed
	 */
	public function getProducts() {
		return $this->plugin->getProducts();
	}

	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getProduct( $id ) {
		return $this->plugin->getProduct( $id );
	}

	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getRelativeProduct( $id ) {
		return $this->plugin->getRelativeProduct( $id );
	}

	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getAbsoluteProduct( $id ) {
		return $this->plugin->getAbsoluteProduct( $id );
	}

	/**
	 * @return mixed
	 */
	public function getCredData() {
		return $this->plugin->getCredData();
	}

	/**
	 * @return mixed
	 */
	public function getNewProductLink() {
		return $this->plugin->getNewProductLink();
	}

	/**
	 * @param $post_id
	 * @param $form_id
	 *
	 * @return mixed
	 */
	public function getCustomer( $post_id, $form_id ) {
		return $this->plugin->getCustomer( $post_id, $form_id );
	}

	/**
	 * @param int $post_id
	 * @param array $form_data
	 */
	public function onSubmitComplete( $post_id, $form_data ) {
		// get form meta data related to cred commerce
		$this->form = $this->model->getForm( $form_data[ 'id' ], false );
		$is_user_form = ( get_post_type( $form_data[ 'id' ] ) == CRED_USER_FORMS_CUSTOM_POST_NAME ) ? true : false;

		if ( $this->form->isCommerce ) {

			do_action( 'cred_commerce_before_add_to_cart', $this->form->ID, $post_id );

			// clear cart if needed
			if ( $this->form->clearCart ) {
				$this->plugin->clearCart();
			}

			// add product to cart
			if ( 'post' == $this->form->associateProduct ) {
				if ( $is_user_form ) {
					if ( ! is_numeric( $post_id ) ) {
						$draft_users = ( class_exists( "CRED_User_Premium_Feature" ) ) ? CRED_User_Premium_Feature::get_instance()->get_draft_users() : CRED_StaticClass::get_draft_users();

						if ( isset( $draft_users[ $post_id ] ) ) {
							$tmp_user = $draft_users[ $post_id ];
							if ( isset( $tmp_user )
								&& isset( $tmp_user[ 'usermeta' ] )
								&& isset( $tmp_user[ 'usermeta' ][ $this->form->productField ] )
							) {
								$product = $tmp_user[ 'usermeta' ][ $this->form->productField ];
							}
						}
					}
				} else {
					$product = $this->model->getPostMeta( $post_id, $this->form->productField );
				}
			} else {
				if ( isset( $this->form->product ) ) {
					$product = $this->form->product;
				} else {
					// No product so return.
					return;
				}
			}

			// HOOKS API allow plugins to filter the product
			$product = apply_filters( 'cred_commerce_add_product_to_cart', $product, $this->form->ID, $post_id );

			$this->plugin->addTocart(
				$product, array(
					'cred_product_id' => $product,
					'cred_form_id' => $this->form->ID,
					'cred_post_id' => $post_id,
				)
			);

			// HOOKS API
			do_action( 'cred_commerce_after_add_to_cart', $this->form->ID, $post_id );
		}
	}

	/**
	 * @deprecated, kept for backwards compatibility. See get_redirect_url on cred_get_form_submit_custom_redirect_url instead.
	 * @param string $action
	 * @param int $post_id
	 * @param array $form_data
	 * @param bool $is_ajax (since cred 1.7)
	 */
	public function onFormSuccessAction( $action, $post_id, $form_data, $is_ajax = false ) {
		if ( $this->form->ID == $form_data[ 'id' ]
			//&& $this->form->isCommerce
		) {
			do_action( 'cred_commerce_form_action', $action, $this->form->ID, $post_id, $form_data, $is_ajax );
		}
	}

	/**
	 * Generate the right redirect URL based on the form submit action.
	 *
	 * @param string|bool $url
	 * @param string $action
	 * @return string|bool
	 */
	public function get_redirect_url( $url, $action ) {
		switch ( $action ) {
			case 'cart':
			case 'checkout':
				return $this->plugin->getPageUri( $action );
		}
		return $url;
	}

	/**
	 * Trigger notifications on order created (on checkout)
	 *
	 * @param $data
	 */
	public function onOrderCreated( $data ) {
		$this->plugin->detach( '_cred_order_created', array( $this, 'onOrderCreated' ) );

		$cred_commerce_command = new CRED_Commerce_Event_OnOrderCreated( $data, $this );
		$cred_commerce_command->execute();
	}

	/**
	 * @param array $data
	 */
	public function onOrderChange( $data ) {
		$this->plugin->detach( '_cred_order_status_changed', array( $this, 'onOrderChange' ) );

		$cred_commerce_command = new CRED_Commerce_Event_OnOrderChange( $data, $this );
		$cred_commerce_command->execute();
	}

	/**
	 * @param array $data
	 */
	public function onOrderComplete( $data ) {
		$this->plugin->detach( '_cred_commerce_order_completed', array( $this, 'onOrderComplete' ) );

		$cred_commerce_command = new CRED_Commerce_Event_OnOrderComplete( $data, $this, 'extra_data' );
		$cred_commerce_command->execute();
	}

	/**
	 * @param array $data
	 */
	public function onOrderReceived( $data ) {
		$this->plugin->detach( '_cred_commerce_order_received', array( $this, 'onOrderReceived' ) );

		$cred_commerce_command = new CRED_Commerce_Event_OnOrderReceived( $data, $this, 'extra_data' );
		$cred_commerce_command->execute();
	}

	/**
	 * @param array $data
	 */
	public function onPaymentFailed( $data ) {
		$this->plugin->detach( '_cred_commerce_payment_failed', array( $this, 'onPaymentFailed' ) );

		$cred_commerce_command = new CRED_Commerce_Event_OnPaymentFailed( $data, $this, 'extra_data' );
		$cred_commerce_command->execute();
	}

	/**
	 * @param array $data
	 */
	public function onPaymentComplete( $data ) {
		$this->plugin->detach( '_cred_commerce_payment_complete', array( $this, 'onPaymentComplete' ) );

		$cred_commerce_command = new CRED_Commerce_Event_OnPaymentComplete( $data, $this, 'extra_data' );
		$cred_commerce_command->execute();
	}

	/**
	 * @param array $data
	 */
	public function onHold( $data ) {
		$this->plugin->detach( '_cred_commerce_on_hold', array( $this, 'onHold' ) );

		$cred_commerce_command = new CRED_Commerce_Event_OnHold( $data, $this, 'extra_data' );
		$cred_commerce_command->execute();
	}

	/**
	 * @param array $data
	 */
	public function onRefund( $data ) {
		$this->plugin->detach( '_cred_commerce_payment_refunded', array( $this, 'onRefund' ) );

		$cred_commerce_command = new CRED_Commerce_Event_OnRefund( $data, $this, 'extra_data' );
		$cred_commerce_command->execute();
	}

	/**
	 * @param array $data
	 */
	public function onCancel( $data ) {
		$this->plugin->detach( '_cred_commerce_payment_cancelled', array( $this, 'onRefund' ) );

		$cred_commerce_command = new CRED_Commerce_Event_OnCancel( $data, $this, 'extra_data' );
		$cred_commerce_command->execute();
	}
}
