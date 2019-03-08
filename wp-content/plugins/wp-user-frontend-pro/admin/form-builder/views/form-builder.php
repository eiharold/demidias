<form id="wpuf-form-builder" class="wpuf-form-builder-<?php echo $form_type; ?>" method="post" action="" @submit.prevent="save_form_builder" v-cloak>
    <h2 class="nav-tab-wrapper">
        <a href="#wpuf-form-builder-container" class="nav-tab nav-tab-active">
            <?php _e( 'Form Editor', 'wpuf-pro' ); ?>
        </a>

        <a href="#wpuf-form-builder-settings" class="nav-tab">
            <?php _e( 'Settings', 'wpuf-pro' ); ?>
        </a>

        <?php do_action( "wpuf-form-builder-tabs-{$form_type}" ); ?>

        <span class="pull-right">
            <button type="button" class="button button-primary" @click="save_form_builder">
                <?php _e( 'Save Form', 'wpuf-pro' ); ?>
            </button>

            <button type="button" class="button">
                <?php _e( 'Preview Form', 'wpuf-pro' ); ?>
            </button>
        </span>
    </h2>

    <div class="tab-contents">
        <div id="wpuf-form-builder-container" class="group active">
            <div id="builder-stage">
                <header class="clearfix">
                    <span class="form-title">{{ post.post_title }}</span>

                    <i class="fa fa-angle-down form-switcher-arrow"></i>
                </header>

                <section>
                    <div id="form-preview">
                        <builder-stage></builder-stage>
                    </div>
                </section>
            </div><!-- #builder-stage -->

            <div id="builder-form-fields">
                <header>
                    <ul class="clearfix">
                        <li :class="['form-fields' === current_panel ? 'active' : '']">
                            <a href="#add-fields" @click.prevent="set_current_panel('form-fields')">
                                <?php _e( 'Add Fields', 'wpuf-pro' ); ?>
                            </a>
                        </li>

                        <li :class="['field-options' === current_panel ? 'active' : '', !form_fields_count ? 'disabled' : '']">
                            <a href="#field-options" @click.prevent="set_current_panel('field-options')">
                                <?php _e( 'Field Options', 'wpuf-pro' ); ?>
                            </a>
                        </li>
                    </ul>
                </header>

                <section>
                    <div class="wpuf-form-builder-panel">
                        <component :is="current_panel"></component>
                    </div>
                </section>
            </div><!-- #builder-form-fields -->
        </div><!-- #wpuf-form-builder-container -->

        <div id="wpuf-form-builder-settings" class="group clearfix">
            <h2 id="wpuf-form-builder-settings-tabs" class="nav-tab-wrapper">
                <?php do_action( "wpuf-form-builder-settings-tabs-{$form_type}" ); ?>
            </h2><!-- #wpuf-form-builder-settings-tabs -->

            <div id="wpuf-form-builder-settings-contents" class="tab-contents">
                <?php do_action( "wpuf-form-builder-settings-tab-contents-{$form_type}" ); ?>
            </div><!-- #wpuf-form-builder-settings-contents -->
        </div><!-- #wpuf-form-builder-settings -->

        <?php do_action( "wpuf-form-builder-tab-contents-{$form_type}" ); ?>
    </div>
</form><!-- #wpuf-form-builder -->
