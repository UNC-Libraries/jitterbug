<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePreservationMasterTableToPreservationInstance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::rename('preservation_masters', 'preservation_instances');
      Schema::rename('audio_masters', 'audio_instances');
      Schema::rename('film_masters', 'film_instances');
      Schema::rename('video_masters', 'video_instances');

      Schema::table('cuts', function (Blueprint $table) {
        $table->renameColumn('preservation_master_id', 'preservation_instance_id');
      });
      Schema::table('transfers', function (Blueprint $table) {
        $table->renameColumn('preservation_master_id', 'preservation_instance_id');
      });

      DB::statement("
        CREATE OR REPLACE VIEW preservation_instance_types AS
          SELECT
            media_types.id,
            TRIM(TRAILING 'instance' FROM preservation_instances.subclass_type) AS name,
            COUNT(preservation_instances.subclass_type) AS count
          FROM
            preservation_instances, media_types
          WHERE
            TRIM(TRAILING 'instance' FROM preservation_instances.subclass_type) = media_types.name
          AND
            preservation_instances.deleted_at is null
          GROUP BY media_types.name;
      ");

      DB::statement('
        CREATE OR REPLACE VIEW preservation_instance_collections AS
          SELECT 
            collections.id AS id,
            collections.name AS name,
          COUNT(audio_visual_items.collection_id) AS count
          FROM
            audio_visual_items,
            preservation_instances,
            collections
          WHERE
            audio_visual_items.collection_id = collections.id
          AND
            audio_visual_items.call_number = preservation_instances.call_number
          AND
            preservation_instances.deleted_at is null
          GROUP BY audio_visual_items.collection_id
          ORDER BY name;
      ');

      DB::statement('
        CREATE OR REPLACE VIEW preservation_instance_formats AS
          SELECT 
            formats.id AS id,
            formats.name AS name,
          COUNT(audio_visual_items.format_id) AS count
          FROM
            audio_visual_items,
            preservation_instances,
            formats
          WHERE
            audio_visual_items.format_id = formats.id
          AND
            audio_visual_items.call_number = preservation_instances.call_number
          AND
            preservation_instances.deleted_at is null
          GROUP BY audio_visual_items.format_id
          ORDER BY name;
      ');

      DB::statement('
        CREATE OR REPLACE VIEW preservation_instance_departments AS
          SELECT 
            departments.id AS id,
            departments.name AS name,
          COUNT(preservation_instances.department_id) AS count
          FROM
            departments,
            preservation_instances
          WHERE
            preservation_instances.department_id = departments.id
          AND
            preservation_instances.deleted_at is null
          GROUP BY preservation_instances.department_id
          ORDER BY name;
      ');

      DB::statement('
        DROP VIEW IF EXISTS preservation_master_types, 
          preservation_master_collections, 
          preservation_master_formats, 
          preservation_master_departments;
      ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::rename('preservation_instances', 'preservation_masters');
      Schema::rename('audio_instances', 'audio_masters');
      Schema::rename('film_instances', 'film_masters');
      Schema::rename('video_instances', 'video_masters');

      Schema::table('cuts', function (Blueprint $table) {
        $table->renameColumn('preservation_instance_id', 'preservation_master_id');
      });
      Schema::table('transfers', function (Blueprint $table) {
        $table->renameColumn('preservation_instance_id', 'preservation_master_id');
      });

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

      DB::statement('
        DROP VIEW IF EXISTS preservation_instance_types, 
          preservation_instance_collections, 
          preservation_instance_formats, 
          preservation_instance_departments;
      ');
    }
}
