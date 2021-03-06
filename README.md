# An Elasticsearch integration for Elgg
This plugin adds full-text search capabilities to your Elgg installation, allowing you to search through entities and annotations (in ELGG 1.8). It replaces the default search and the search_advanced plugin.

## Installation and configuration
1. Install the plugin (and it's dependencies) by running:

        composer require pleio/elasticsearch

2. Add the following configuration to engine/settings.php:

        $CONFIG->elasticsearch = array(
            'hosts' => array(
                '127.0.0.1'
            )
        );

        $CONFIG->elasticsearch_index = 'pleio-dev';

3. Activate the plugin through the Elgg admin panel, make sure you deactivated the search and search_advanced plugin.
4. Create the index and mappings in Elasticsearch by running:

        php console.php es:index:reset

This command will (re-)create the index. All existing content attached to the Elasticsearch will be deleted. From now on all entity CRUD actions will automatically be synced with Elasticsearch.

## Bulk synchronisation
The tool comes with a tool to synchronize all existing content with Elasticsearch. Run

    php console.php es:sync:all

to start a bulk synchronisation.