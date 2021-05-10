<?php

/**
 * Class CRED_Commerce_OnOrderComplete_Event
 *
 * @since 1.7
 */
class CRED_Commerce_Event_OnOrderComplete extends CRED_Commerce_Event_Base {

	public function execute() {
		parent::execute();

		$this->update_order_user();

		$cred_forms_meta = $this->cred_forms_meta;
		if ( ! empty( $cred_forms_meta ) ) {
			$notification_handler = null;
			foreach ( $cred_forms_meta as $form_id => $cred_form_meta_object ) {
				$form = $cred_form_meta_object->get_form();
				$form_id = $cred_form_meta_object->get_form_id();
				$form_slug = $cred_form_meta_object->get_form_slug();
				$cred_meta = $cred_form_meta_object->get_meta();
				$customer = $this->plugin->getCustomer( $cred_form_meta_object->get_referred_object_id(), $form_id );
				$is_commerce = $form->isCommerce;
				if ( $is_commerce ) {
					$form_type = $cred_form_meta_object->get_type_form();
					$notification_class = $this->get_notification_class_by_form_type( $form_type );
					$notification_handler = new $notification_class( $customer, $this->data_order, $cred_form_meta_object );
					$notification_handler->on_order_completed_event();
				}
			}

			do_action( 'cred_commerce_after_order_completed_form_' . $form_slug, $this->data_order );
			do_action( 'cred_commerce_after_order_completed', $this->data_order );
		}
	}

	/**
	 * Updates User in the Order if it has been purchased by a Guest
	 */
	private function update_order_user() {
		if ( ! empty( $this->data_order['user_id'] ) && ! empty( $this->data_order['transaction_id'] ) ) {
			$user_id = get_post_meta( $this->data_order['transaction_id'], '_customer_user', true );

			if ( ! $user_id ) {
				update_post_meta( $this->data_order['transaction_id'], '_customer_user', $this->data_order['user_id'] );
			}
		}
	}
}
