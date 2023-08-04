<?php
/**
 * Created by PhpStorm.
 * User: mimotic
 * Date: 16/12/2020
 * Time: 19:07
 */

function simplygest_settings_page() {
    add_settings_section("section", "Eliminar borradores", null, "simplygest");
    add_settings_field("simplygest-remove", "Borrar cada pocos minutos", "simplygest_checkbox_display", "simplygest", "section");
    register_setting("section", "simplygest-remove");
}

function simplygest_checkbox_display() {
    ?>
    <!-- Here we are comparing stored value with 1. Stored value is 1 if user checks the checkbox otherwise empty string. -->
    <input type="checkbox" name="simplygest-remove" value="1" <?php checked(1, get_option('simplygest-remove'), true); ?> />
    <?php
}

add_action("admin_init", "simplygest_settings_page");

function simplygest_page() {
    ?>
    <div class="wrap">
        <h1>Fix Simplygest Integration</h1>
        <p>Si se activa este servicio cada pocos minutos se borran automáticamente todos los prodcutos que estén como borrador de forma definitiva (no se pueden recuperar)</p>

        <form method="post" action="options.php">
            <?php
            settings_fields("section");

            do_settings_sections("simplygest");

            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function menu_item() {
    add_submenu_page("options-general.php", "Simplygest", "Simplygest", "manage_options", "simplygest", "simplygest_page");
}

add_action("admin_menu", "menu_item");
