---
categories: [www]
date: 2022-09-09T00:18:55-04:00
guid: 'https://www.tobymackenzie.com/blog/?p=3821'
id: 3821
image: 2022/09/Screen-Shot-2022-09-08-at-23.49.05.png
modified: 2023-04-11T15:58:11-04:00
name: wordpress-quick-dirty-dark-mode-admin
tags: [ab, admin, dark-mode, plugin, wordpress]
---

WordPress dark mode for admin, quick and dirty
==============================================

I have been loving that so many apps and sites have been moving to supporting dark modes.  I find it easier on my eyes, especially in the evening / night.  One place that I frequently visit that I'm disappointed doesn't support dark mode yet is WordPress's admin area.

There is a [Dark Mode plugin](https://wordpress.org/plugins/wp-dark-mode/) that can add this, but it is primarily for the front-end of the site, which in my case already has a dark mode and I didn't want to touch.  Plus it's a lot of third party code for something that should be built in and probably will be at some point.  I decided it was time to look into if I could just inject a quick and dirty stylesheet to change some colors and improve the situation for now.

<!--more-->

It wasn't too hard just to inject a stylesheet.  It is similar to injecting a stylesheet into the site frontend, with an `add_action()` call, in this case using the `admin_enqueue_scripts` event.  It can be done in `functions.php`, but I decided to do it in a plugin.  The simple code looks like:

``` php
add_action('admin_enqueue_scripts', function(){
	wp_enqueue_style('tjm-dark-admin', plugin_dir_url(__FILE__) . '/styles.css');
});
```

The styles have been a little more work than I had hoped.  The admin doesn't use CSS variables and has a lot of different colors defined in a lot of selectors.  Plugins really complicate the situation.  I have worked over a few days to find elements I missed.  I now have a decent dark green scheme that makes things dark, though not necessarily looking good and polished.

I put the styles in `@media (prefers-color-scheme: dark)` so that the light mode remains untouched and can be switched to if there's anything unusable due to the mix of styles.  I only changed colors and used CSS variables to make it easy to change them in one place without requiring SASS or the like.  I left a number of the built-in colors untouched when they didn't look too bad, and I'm sure there's plenty that I missed.

[My results thus far](https://github.com/tobymackenzie/tobymackenzie.site/tree/c73866019c2c7f09a10f069112c890d63bf08fa3/src/Blog/plugins/tjm-dark-admin) can be found in [this site's Github repo](https://github.com/tobymackenzie/tobymackenzie.site).  Here is a slightly abridged version of the current styles:

``` css
@media (prefers-color-scheme: dark){
	:root{
		--tm-primary-bg: #010;
		--tm-primary-fg: #cfe;
		--tm-primary-fg-alt: #afa;
		--tm-primary-fg-subdued: #ada;
		--tm-secondary-bg: #021;
		--tm-secondary-bg-alt: #141;
		--tm-secondary-fg: #6ea;
		--tm-action-fg: #6ea;
		--tm-exclaim-bg: #794;
		--tm-exclaim-bg-focus: #9b6;
		--tm-exclaim-fg: #fff;
		--tm-focus-bg: #143;
		--tm-gray: #aaa;
	}
	body.wp-admin.wp-admin{
		--wp-admin-theme-color: var(--tm-exclaim-bg);
		--wp-admin-theme-color-rgb: 119, 153, 68;
	}

	/*=====
	==shell
	*/
	body{
		background: var(--tm-primary-bg);
		color: var(--tm-primary-fg);
	}

	/*--main */
	.ac_match, .subsubsub a.current{
		color: var(--tm-primary-fg);
	}
	.alternate, .striped > tbody > :nth-child(2n+1), ul.striped > :nth-child(2n+1){
		background: var(--tm-secondary-bg);
	}
	.attachments-browser .media-toolbar{
		background: var(--tm-secondary-bg);
	}
	.card{
		background: var(--tm-secondary-bg);
	}
	.categorydiv div.tabs-panel, .customlinkdiv div.tabs-panel, .posttypediv div.tabs-panel, .taxonomydiv div.tabs-panel, .wp-tab-panel{
		background: var(--tm-secondary-bg);
	}
	#major-publishing-actions{
		background: var(--tm-secondary-bg);
	}
	.postbox{
		background: var(--tm-secondary-bg);
	}
	#screen-meta{
		background: var(--tm-primary-bg);
	}
	#wp-content-editor-tools{
		background: var(--tm-primary-bg);
	}
	#wpbody-content#wpbody-content{
		background: var(--tm-primary-bg);
	}

	/*--sidebar */
	#adminmenu, #adminmenuback, #adminmenuwrap{
		background: var(--tm-secondary-bg);
	}
	#adminmenu a{
		color: var(--tm-primary-fg);
	}
	#adminmenu .wp-has-current-submenu .wp-submenu, #adminmenu .wp-has-current-submenu.opensub .wp-submenu, #adminmenu .wp-submenu, #adminmenu a.wp-has-current-submenu:focus + .wp-submenu{
		background: var(--tm-secondary-bg-alt);
	}
	#customize-controls .customize-info .accordion-section-title, .customize-section-title{
		background-color: var(--tm-secondary-alt);
		color: var(--tm-secondary-fg);
	}
	#customize-controls .customize-info .customize-panel-description, #customize-controls .customize-info .customize-section-description, #customize-controls .no-widget-areas-rendered-notice, #customize-outer-theme-controls .customize-info .customize-section-description,	#customize-theme-controls .control-panel-themes > .accordion-section-title, #customize-theme-controls .control-panel-themes > .accordion-section-title:hover, #customize-outer-theme-controls .accordion-section-title, #customize-theme-controls .accordion-section-title, .expanded .wp-full-overlay-footer{
		background-color: var(--tm-secondary-bg);
		color: var(--tm-primary-fg);
	}
	#customize-controls .description{
		color: var(--tm-gray);
	}
	.customize-controls-close{
		background-color: var(--tm-secondary-alt);
		color: var(--tm-secondary-fg);
	}
	.customize-section-title h3, h3.customize-section-title{
		color: var(--tm-secondary-fg);
	}
	#customize-outer-theme-controls .accordion-section-content, #customize-theme-controls .accordion-section-content{
		color: var(--tm-primary-fg);
	}
	#customize-sidebar-outer-content{
		background-color: var(--tm-secondary-bg);
	}
	.wp-core-ui .wp-full-overlay .collapse-sidebar, .wp-full-overlay-footer .devices button.active::before{
		color: var(--tm-secondary-fg);
	}
	.wp-full-overlay-footer .devices{
		background-color: var(--tm-secondary-bg);
	}
	.wp-full-overlay-sidebar, .wp-full-overlay-sidebar .wp-full-overlay-header{
		background-color: var(--tm-secondary-bg);
	}
	#wpadminbar{
		color: var(--tm-primary-fg);
		background: var(--tm-secondary-bg);
	}

	/*=====
	==modules
	*/
	a{
		color: var(--tm-action-fg);
	}
	h1, h2, h3, h4, h5, h6{
		color: var(--tm-primary-fg-alt);
	}
	.notice, div.error, div.updated{
		background: var(--tm-exclaim-bg);
		color: var(--tm-exclaim-fg);
	}

	/*--actions */
	.customize-control .attachment-media-view .button-add-media, .customize-panel-back, .customize-section-back, .wp-core-ui .button, .wp-core-ui .button-secondary, .wp-color-result-text{
		background: var(--tm-exclaim-bg);
		color: var(--tm-exclaim-fg);
	}
	.customize-control .attachment-media-view .button-add-media:hover, .customize-panel-back:focus, .customize-panel-back:hover, .customize-section-back:focus, .customize-section-back:hover{
		background: var(--tm-exclaim-bg-focus);
	}
	#post-body ul.add-menu-item-tabs li.tabs a, #post-body ul.category-tabs li.tabs a, #side-sortables .add-menu-item-tabs .tabs a, #side-sortables .category-tabs .tabs a, .wp-tab-bar .wp-tab-active a{
		color: var(--tm-exclaim-fg);
	}
	.wp-core-ui .button-disabled, .wp-core-ui .button-secondary.disabled, .wp-core-ui .button-secondary:disabled, .wp-core-ui .button-secondary[disabled], .wp-core-ui .button.disabled, .wp-core-ui .button:disabled, .wp-core-ui .button[disabled]{
		background: var(--tm-secondary-bg) !important;
		color: var(--tm-secondary-fg) !important;
	}
	.wp-tab-active, ul.add-menu-item-tabs li.tabs, ul.category-tabs li.tabs{
		background: var(--tm-exclaim-bg);
		color: var(--tm-exclaim-fg);
	}
	.wrap .page-title-action, .wrap .page-title-action:active{
		background: var(--tm-exclaim-bg);
		color: var(--tm-exclaim-fg);
	}

	/*--forms */
	.comment-ays, .feature-filter, .imgedit-group, .popular-tags, .stuffbox, .widgets-holder-wrap, .wp-editor-container, p.popular-tags, table.widefat{
		background: var(--tm-primary-bg);
		color: var(--tm-primary-fg);
	}
	.form-table th, .form-wrap label{
		color: var(--tm-primary-fg-alt);
	}
	.form-wrap p, p.description{
		color: var(--tm-primary-fg);
	}
	input[type="color"], input[type="date"], input[type="datetime-local"], input[type="datetime"], input[type="email"], input[type="month"], input[type="number"], input[type="password"], input[type="search"], input[type="tel"], input[type="text"], input[type="time"], input[type="url"], input[type="week"], select, textarea{
		background-color: var(--tm-primary-bg);
		color: var(--tm-primary-fg);
	}
	input.readonly, input[readonly], textarea.readonly, textarea[readonly]{
		background: var(--tm-primary-bg);
	}
	.media-frame input[type="color"], .media-frame input[type="date"], .media-frame input[type="datetime-local"], .media-frame input[type="datetime"], .media-frame input[type="email"], .media-frame input[type="month"], .media-frame input[type="number"], .media-frame input[type="password"], .media-frame input[type="search"], .media-frame input[type="tel"], .media-frame input[type="text"], .media-frame input[type="time"], .media-frame input[type="url"], .media-frame input[type="week"], .media-frame select, .media-frame textarea{
		background-color: var(--tm-primary-bg);
		color: var(--tm-primary-fg);
	}
	#postcustomstuff table{
		background: var(--tm-secondary-bg);
	}
	#postcustomstuff thead th{
		background: var(--tm-secondary-bg-alt);
		color: var(--tm-primary-fg-alt);
	}
	.quicktags-toolbar.quicktags-toolbar{
		background: var(--tm-secondary-bg-alt);
	}
	#titlediv #title{
		background: var(--tm-primary-bg);
		color: var(--tm-primary-fg);
	}
	.ui-autocomplete{
		background: var(--tm-secondary-bg-alt);
	}
	.wp-core-ui select{
		background-color: var(--tm-exclaim-bg);
		color: var(--tm-exclaim-fg);
	}
	.wp-core-ui select.disabled, .wp-core-ui select:disabled{
		background-color: var(--tm-primary-bg);
		color: var(--tm-primary-fg-subdued);
	}
	.wp-filter{
		color: var(--tm-gray);
		background-color: var(--tm-secondary-bg);
	}

	/*--tables */
	.plugins .active td, .plugins .active th{
		background: var(--tm-exclaim-bg);
		color: var(--tm-exclaim-fg);
	}
	.plugins tr{
		background: var(--tm-primary-bg);
	}
	.widefat ol, .widefat p, .widefat ul{
		color: var(--tm-primary-fg);
	}
	.widefat tfoot tr td, .widefat tfoot tr th, .widefat thead tr td, .widefat thead tr th{
		color: var(--subdued-fg);
	}
	.widefat td, .widefat th{
		color: var(--tm-primary-fg);
	}

	/*--etc */
	.attachment-details .setting .name, .attachment-details .setting .value, .attachment-details .setting span, .compat-item label span, .media-sidebar .checkbox-label-inline, .media-sidebar .setting .name, .media-sidebar .setting .value, .media-sidebar .setting span{
		color: var(--tm-primary-fg-alt);
	}
	.attachment-info{
		color: var(--tm-primary-fg-alt);
	}
	.attachment-info .filename{
		color: var(--tm-primary-fg);
	}
	.block-editor-block-breadcrumb__button.components-button, .block-editor-block-breadcrumb__current{
		color: var(--tm-secondary-fg);
	}
	.block-editor-block-contextual-toolbar, .components-popover__content{
		background: var(--tm-secondary-bg);
		border-color: var(--tm-exclaim-bg);
		color: var(--tm-exclaim-fg);
	}
	.block-editor-block-icon svg{
		fill: var(--tm-secondary-fg);
	}
	.block-editor-button-block-appender.components-button.components-button{
		background: var(--tm-exclaim-bg);
		color: var(--tm-exclaim-fg);
	}
	.blocks-widgets-container .interface-interface-skeleton__content{
		background: var(--tm-primary-bg);
	}
	.blocks-widgets-container .wp-block-widget-area__inner-blocks.editor-styles-wrapper{
		background: var(--tm-secondary-bg);
	}
	.components-button{
		color: var(--tm-exclaim-fg);
	}
	.components-button.edit-widgets-sidebar__panel-tab{
		color: var(--tm-secondary-fg);
	}
	.components-panel{
		background: var(--tm-secondary-bg);
	}
	.components-panel__body-toggle.components-button{
		color: var(--tm-primary-fg-alt);
	}
	#contextual-help-back{
		background: var(--tm-secondary-bg);
	}
	#dashboard-widgets h3, #dashboard-widgets h4, #dashboard_quick_press .drafts h2{
		color: var(--tm-primary-fg-alt);
	}
	.edit-attachment-frame .attachment-info{
		background: var(--tm-secondary-bg-alt);
	}
	.edit-attachment-frame .attachment-info .filename{
		color: var(--tm-primary-fg);
	}
	.importer-title{
		color: var(--tm-primary-fg);
	}
	.interface-complementary-area{
		color: var(--tm-primary-fg);
	}
	.interface-complementary-area-header{
		background-color: var(--tm-secondary-bg-alt);
	}
	.interface-interface-skeleton__footer, .interface-interface-skeleton__footer .block-editor-block-breadcrumb, .interface-interface-skeleton__secondary-sidebar, .interface-interface-skeleton__sidebar{
		background-color: var(--tm-secondary-bg);
		color: var(--tm-primary-fg);
	}
	.interface-interface-skeleton__header{
		background-color: var(--tm-secondary-bg-alt);
		color: var(--tm-secondary-fg);
	}
	.iris-border{
		background-color: var(--tm-secondary-bg-alt);
	}
	.item-type{
		color: var(--tm-primary-fg);
	}
	.media-frame-content{
		background: var(--tm-secondary-bg);
	}
	.media-modal-content{
		background: var(--tm-secondary-bg);
	}
	.media-sidebar{
		background: var(--tm-secondary-bg);
	}
	.menu-item-handle, .widget .widget-top{
		color: var(--tm-exclaim-fg);
	}
	.notice-warning.notice-alt{
		background: var(--tm-exclaim-bg);
		color: var(--tm-exclaim-fg);
	}
	#plugin-information .fyi, #plugin-information-footer, #plugin-information-tabs, #TB_window.plugin-details-modal{
		background: var(--tm-secondary-bg);
		color: var(--tm-primary-fg);
	}
	#plugin-information .fyi strong{
		color: var(--tm-secondary-fg);
	}
	#plugin-information-content, #plugin-information-tabs a.current, #plugin-information-title{
		background: var(--tm-secondary-bg-alt);
		color: var(--tm-exclaim-fg);
	}
	.privacy_requests tbody td{
		background: var(--tm-primary-bg);
	}
	#screen-meta-links .show-settings{
		background-color: var(--tm-exclaim-bg);
		color: var(--tm-exclaim-fg);
	}
	.theme-overlay .theme-actions{
		background: var(--tm-secondary-bg-alt);
	}
	.theme-browser .theme .theme-screenshot.blank, .theme-overlay .screenshot.blank{
		filter: invert(1);
	}
	.widget-inside, .wp-block-legacy-widget__edit-form{
		background: var(--tm-secondary-bg);
	}
	.wp-block[data-type="core/widget-area"] .components-panel__body > .components-panel__body-title{
		background: var(--tm-secondary-bg-alt);
	}
	.wp-block-legacy-widget__edit-form.wp-block-legacy-widget__edit-form, .wp-block-legacy-widget__edit-no-preview.wp-block-legacy-widget__edit-no-preview{
		color: var(--tm-primary-fg);
	}
	.wp-block-legacy-widget__edit-form .wp-block-legacy-widget__edit-form-title, .wp-block-legacy-widget__edit-form .widget-inside.widget-inside a, .wp-block-legacy-widget__edit-form .widget-inside.widget-inside input, .wp-block-legacy-widget__edit-form .widget-inside.widget-inside label{
		color: var(--tm-secondary-fg);
	}
	.wp-block-legacy-widget__edit-form .widget-inside.widget-inside input[type="date"], .wp-block-legacy-widget__edit-form .widget-inside.widget-inside input[type="datetime-local"], .wp-block-legacy-widget__edit-form .widget-inside.widget-inside input[type="datetime"], .wp-block-legacy-widget__edit-form .widget-inside.widget-inside input[type="email"], .wp-block-legacy-widget__edit-form .widget-inside.widget-inside input[type="month"], .wp-block-legacy-widget__edit-form .widget-inside.widget-inside input[type="number"], .wp-block-legacy-widget__edit-form .widget-inside.widget-inside input[type="password"], .wp-block-legacy-widget__edit-form .widget-inside.widget-inside input[type="search"], .wp-block-legacy-widget__edit-form .widget-inside.widget-inside input[type="tel"], .wp-block-legacy-widget__edit-form .widget-inside.widget-inside input[type="text"], .wp-block-legacy-widget__edit-form .widget-inside.widget-inside input[type="time"], .wp-block-legacy-widget__edit-form .widget-inside.widget-inside input[type="url"], .wp-block-legacy-widget__edit-form .widget-inside.widget-inside input[type="week"], .wp-block-legacy-widget__edit-form .widget-inside.widget-inside select{
		background: var(--tm-secondary-bg-alt);
		color: var(--tm-secondary-fg);
	}
	.wp-customizer .menu-item-bar .menu-item-handle{
		background: var(--tm-secondary-bg-alt);
	}
	.wp-customizer .menu-item-settings{
		background: var(--tm-secondary-bg-alt);
	}

	/*--theme */
	.theme-overlay .theme-wrap{
		background: var(--tm-secondary-bg);
		color: var(--tm-secondary-fg);
	}
}
```

The [full version can be found here](https://github.com/tobymackenzie/tobymackenzie.site/blob/master/src/Blog/plugins/tjm-dark-admin/styles.css).  Much of that is just for JetPack, and I had to increase the selector specificity because their styles must load after mine.  They make use of `!important`, so so must I.  I had to `invert()` their stats charts since they were done as canvas.

All of these styles are probably fragile and could easily break with an update, but they work as of WordPress 6.0.2 and JetPack 11.3.  Like I said, they are not in any way polished, but they work to make things much darker.  Hopefully WordPress team is working on making this built in.
