<?php

require_once(dirname(__FILE__) . "/../../vendor/autoload.php");
require_once(dirname(__FILE__) . "/lib/functions.php");
require_once(dirname(__FILE__) . "/lib/events.php");

function elasticsearch_init() {
    elgg_register_event_handler('create', 'user', 'elasticsearch_create_event');
    elgg_register_event_handler('create', 'group', 'elasticsearch_create_event');
    elgg_register_event_handler('create', 'object', 'elasticsearch_create_event');
    elgg_register_event_handler('create', 'site', 'elasticsearch_create_event');
    elgg_register_event_handler('create', 'annotation', 'elasticsearch_create_event');

    elgg_register_event_handler('update', 'user', 'elasticsearch_update_event');
    elgg_register_event_handler('update', 'group', 'elasticsearch_update_event');
    elgg_register_event_handler('update', 'object', 'elasticsearch_update_event');
    elgg_register_event_handler('update', 'site', 'elasticsearch_update_event');
    elgg_register_event_handler('update', 'annotation', 'elasticsearch_update_event');

    elgg_register_event_handler('delete', 'user', 'elasticsearch_delete_event');
    elgg_register_event_handler('delete', 'group', 'elasticsearch_delete_event');
    elgg_register_event_handler('delete', 'object', 'elasticsearch_delete_event');
    elgg_register_event_handler('delete', 'site', 'elasticsearch_delete_event');
    elgg_register_event_handler('delete', 'annotation', 'elasticsearch_delete_event');

    elgg_register_event_handler('enable', 'user', 'elasticsearch_enable_event');
    elgg_register_event_handler('enable', 'group', 'elasticsearch_enable_event');
    elgg_register_event_handler('enable', 'object', 'elasticsearch_enable_event');
    elgg_register_event_handler('enable', 'site', 'elasticsearch_enable_event');
    elgg_register_event_handler('enable', 'annotation', 'elasticsearch_enable_event');

    elgg_register_event_handler('disable', 'user', 'elasticsearch_disable_event');
    elgg_register_event_handler('disable', 'group', 'elasticsearch_disable_event');
    elgg_register_event_handler('disable', 'object', 'elasticsearch_disable_event');
    elgg_register_event_handler('disable', 'site', 'elasticsearch_disable_event');
    elgg_register_event_handler('disable', 'annotation', 'elasticsearch_disable_event');

    elgg_register_action("elasticsearch/settings/save", dirname(__FILE__) . "/actions/plugins/settings/save.php", "admin");

    if (elgg_get_plugin_setting('is_enabled', 'elasticsearch') == "yes") {
        elgg_extend_view('css/elgg', 'search/css/site');
        elgg_extend_view('js/elgg', 'search/js/site');

        elgg_extend_view('page/elements/header', 'elasticsearch/header');

        elgg_register_widget_type("search", elgg_echo("search"), elgg_echo("search"), "profile,dashboard,index,groups", true);

        elgg_register_page_handler('search', 'elasticsearch_search_page_handler');
        elgg_register_page_handler('search_advanced', 'elasticsearch_search_page_handler');
    }

    if (function_exists('pleio_register_console_handler')) {
        pleio_register_console_handler('es:index:reset', 'Reset the configured Elasticsearch index.', 'elasticsearch_console_index_reset');
        pleio_register_console_handler('es:sync:all', 'Synchronise all entities to Elasticsearch.', 'elasticsearch_console_sync_all');
    }
}

elgg_register_event_handler("init", "system", "elasticsearch_init");

function elasticsearch_search_page_handler($page) {
    $base_dir = dirname(__FILE__) . '/pages/search';

    switch ($page[0]) {
        case "autocomplete":
            include_once("$base_dir/autocomplete.php");
            return true;
    }

    include_once("$base_dir/index.php");
    return true;
}