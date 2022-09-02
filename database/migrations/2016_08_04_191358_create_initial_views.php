<?php

use Illuminate\Database\Migrations\Migration;

class CreateInitialViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE OR REPLACE VIEW audio_visual_item_collections AS 
          SELECT 
            collections.id AS id, 
            collections.name AS name, 
          COUNT(audio_visual_items.collection_id) AS count 
          FROM 
            audio_visual_items,
            collections 
          WHERE 
            audio_visual_items.collection_id = collections.id 
          AND 
            audio_visual_items.deleted_at is null 
          GROUP BY audio_visual_items.collection_id
          ORDER BY name;
      ');

        DB::statement('
        CREATE OR REPLACE VIEW audio_visual_item_formats AS
          SELECT 
            formats.id AS id,
            formats.name AS name,
          COUNT(audio_visual_items.format_id) AS count
          FROM
            formats,
            audio_visual_items
          WHERE
            audio_visual_items.format_id = formats.id
          AND
            audio_visual_items.deleted_at is null
          GROUP BY audio_visual_items.format_id
          ORDER BY name;
      ');

        DB::statement("
        CREATE OR REPLACE VIEW audio_visual_item_types AS
          SELECT
            media_types.id,
            TRIM(TRAILING 'Item' FROM audio_visual_items.subclass_type) AS name,
            COUNT(audio_visual_items.subclass_type) AS count
          FROM
            audio_visual_items, media_types
          WHERE
            TRIM(TRAILING 'Item' FROM audio_visual_items.subclass_type) = media_types.name
          AND
            audio_visual_items.deleted_at is null
          GROUP BY media_types.name;
      ");

        DB::statement("
        CREATE OR REPLACE VIEW transfer_types AS
          SELECT
            media_types.id,
            TRIM(TRAILING 'Transfer' FROM transfers.subclass_type) AS name,
            COUNT(transfers.subclass_type) AS count
          FROM
            transfers, media_types
          WHERE
            TRIM(TRAILING 'Transfer' FROM transfers.subclass_type) = media_types.name
          AND
            transfers.deleted_at is null
          GROUP BY media_types.name;
      ");

        DB::statement('
        CREATE OR REPLACE VIEW transfer_collections AS
          SELECT 
            collections.id AS id,
            collections.name AS name,
          COUNT(audio_visual_items.collection_id) AS count
          FROM
            audio_visual_items,
            transfers,
            collections
          WHERE
            audio_visual_items.collection_id = collections.id
          AND
            audio_visual_items.call_number = transfers.call_number
          AND
            transfers.deleted_at is null
          GROUP BY audio_visual_items.collection_id
          ORDER BY name;
      ');

        DB::statement('
        CREATE OR REPLACE VIEW transfer_formats AS
          SELECT 
            formats.id AS id,
            formats.name AS name,
          COUNT(audio_visual_items.format_id) AS count
          FROM
            audio_visual_items,
            transfers,
            formats
          WHERE
            audio_visual_items.format_id = formats.id
          AND
            audio_visual_items.call_number = transfers.call_number
          AND
            transfers.deleted_at is null
          GROUP BY audio_visual_items.format_id
          ORDER BY name;
      ');

        DB::statement("
        CREATE OR REPLACE VIEW preservation_master_types AS
          SELECT
            media_types.id,
            TRIM(TRAILING 'Master' FROM preservation_masters.subclass_type) AS name,
            COUNT(preservation_masters.subclass_type) AS count
          FROM
            preservation_masters, media_types
          WHERE
            TRIM(TRAILING 'Master' FROM preservation_masters.subclass_type) = media_types.name
          AND
            preservation_masters.deleted_at is null
          GROUP BY media_types.name;
      ");

        DB::statement('
        CREATE OR REPLACE VIEW preservation_master_collections AS
          SELECT 
            collections.id AS id,
            collections.name AS name,
          COUNT(audio_visual_items.collection_id) AS count
          FROM
            audio_visual_items,
            preservation_masters,
            collections
          WHERE
            audio_visual_items.collection_id = collections.id
          AND
            audio_visual_items.call_number = preservation_masters.call_number
          AND
            preservation_masters.deleted_at is null
          GROUP BY audio_visual_items.collection_id
          ORDER BY name;
      ');

        DB::statement('
        CREATE OR REPLACE VIEW preservation_master_formats AS
          SELECT 
            formats.id AS id,
            formats.name AS name,
          COUNT(audio_visual_items.format_id) AS count
          FROM
            audio_visual_items,
            preservation_masters,
            formats
          WHERE
            audio_visual_items.format_id = formats.id
          AND
            audio_visual_items.call_number = preservation_masters.call_number
          AND
            preservation_masters.deleted_at is null
          GROUP BY audio_visual_items.format_id
          ORDER BY name;
      ');

        DB::statement('
        CREATE OR REPLACE VIEW preservation_master_departments AS
          SELECT 
            departments.id AS id,
            departments.name AS name,
          COUNT(preservation_masters.department_id) AS count
          FROM
            departments,
            preservation_masters
          WHERE
            preservation_masters.department_id = departments.id
          AND
            preservation_masters.deleted_at is null
          GROUP BY preservation_masters.department_id
          ORDER BY name;
      ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS audio_visual_item_collections');
        DB::statement('DROP VIEW IF EXISTS audio_visual_item_formats');
        DB::statement('DROP VIEW IF EXISTS audio_visual_item_types');
        DB::statement('DROP VIEW IF EXISTS transfer_types');
        DB::statement('DROP VIEW IF EXISTS transfer_collections');
        DB::statement('DROP VIEW IF EXISTS transfer_formats');
        DB::statement('DROP VIEW IF EXISTS preservation_master_types');
        DB::statement('DROP VIEW IF EXISTS preservation_master_collections');
        DB::statement('DROP VIEW IF EXISTS preservation_master_formats');
        DB::statement('DROP VIEW IF EXISTS preservation_master_departments');
    }
}
