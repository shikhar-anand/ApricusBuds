<!-- Using "Genesis Post Template - Editable" will drop support of Genesis post hooks -->
<article class="[wpv-post-class]" itemscope="" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
	<header class="entry-header">
		<h2 class="entry-title" itemprop="headline">
			<a href="[wpv-post-url]" rel="bookmark">
				[wpv-post-title]
			</a>
		</h2>

		<p class="entry-meta">
			<time class="entry-time" itemprop="datePublished" datetime="[wpv-post-date format='c']">
				[wpv-post-date]
			</time>

			by
			<span class="entry-author" itemprop="author" itemscope="" itemtype="http://schema.org/Person">
				<a href="[wpv-post-author format='url']" class="entry-author-link" itemprop="url" rel="author">
					<span class="entry-author-name" itemprop="name">[wpv-post-author]</span>
				</a>
			</span>

			<span class="entry-comments-link">
				[wpv-post-comments-number]
			</span>
		</p>
	</header>
	<div class="entry-content" itemprop="text">
		[wpv-post-body view_template="None"]
	</div>
	<footer class="entry-footer">
		<p class="entry-meta">
			[wpv-conditional if="'[wpv-post-taxonomy type=category format=name]' != ''"]
			<span class="entry-categories">
				Filed Under:
				[wpv-post-taxonomy type="category"]
			</span>
			[/wpv-conditional]

			[wpv-conditional if="'[wpv-post-taxonomy type=post_tag format=name]' != ''"]
			<span class="entry-tags">Tagged With:
				[wpv-post-taxonomy type="post_tag"]
			</span>
			[/wpv-conditional]
		</p>
	</footer>
</article>
[genesis-comments-template]