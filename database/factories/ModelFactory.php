<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Jitterbug\Models\Activity::class, function (Faker\Generator $faker) {
  return [
    'transaction_id' => $faker->word,
    'action' => $faker->word,
    'batch' => $faker->boolean,
    'batch_size' => $faker->randomNumber(),
    'field' => $faker->word,
    'import_type' => $faker->word,
    'item_call_number' => $faker->word,
    'item_type' => $faker->word,
    'num_fields' => $faker->boolean,
    'num_affected' => $faker->randomNumber(),
    'object_types_to_ids' => $faker->text,
    'timestamp' => $faker->dateTimeBetween(),
    'user' => $faker->word,
  ];
});

$factory->define(Jitterbug\Models\AudioItem::class, function (Faker\Generator $faker) {
  return [
    'call_number' => $faker->word,
    'listening_copy' => $faker->boolean,
    'size' => null,
    'track_configuration' => null,
    'mono_stereo' => 'M',
    'base' => $faker->word,
    'content_description' => $faker->text,
  ];
});

$factory->define(Jitterbug\Models\AudioMaster::class, function (Faker\Generator $faker) {
  return [
    'tape_brand_id' => function () {
      return factory(Jitterbug\Models\TapeBrand::class)->create()->id;
    },
    'pm_speed_id' => function () {
      return factory(Jitterbug\Models\PmSpeed::class)->create()->id;
    },
    'sampling_rate_id' => function () {
      return factory(Jitterbug\Models\SamplingRate::class)->create()->id;
    },
    'test_tones' => $faker->word,
  ];
});

$factory->define(Jitterbug\Models\AudioTransfer::class, function (Faker\Generator $faker) {
  return [
    'stylus' => $faker->word,
    'cartridge' => $faker->word,
    'first_sound' => $faker->text,
  ];
});

$factory->define(Jitterbug\Models\AudioVisualItem::class, function (Faker\Generator $faker) {
  return [
    'call_number' => 'FS-'.$faker->randomNumber(4),
    'title' => $faker->text,
    'recording_location' => 'Durham, NC',
    'physical_location' => null,
    'access_restrictions' => null,
    'item_year' => (string) $faker->numberBetween(1920, 2015),
    'item_date' => $faker->date(),
    'collection_id' => function () {
      return factory(Jitterbug\Models\Collection::class)->create()->id;
    },
    'accession_number' => $faker->randomNumber(),
    'legacy' => null,
    'container_note' => $faker->text,
    'condition_note' => $faker->text,
    'oclc' => null,
    'format_id' => function () {
      return factory(Jitterbug\Models\Format::class)->create()->id;
    },
    'reel_tape_number' => $faker->word,
    'entry_date' => $faker->date(),
    'speed' => $faker->word,
    'subclass_type' => 'AudioItem',
    'subclass_id' => function (array $audio_visual_item) {
      return factory(Jitterbug\Models\AudioItem::class)->create([
        'call_number' => $audio_visual_item['call_number'],
      ])->id;
    },
  ];
});

$factory->define(Jitterbug\Models\AudioVisualItemCollection::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
    'count' => $faker->randomNumber(),
  ];
});

$factory->define(Jitterbug\Models\AudioVisualItemFormat::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
    'count' => $faker->randomNumber(),
  ];
});

$factory->define(Jitterbug\Models\AudioVisualItemType::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
    'count' => $faker->randomNumber(),
  ];
});

$factory->define(Jitterbug\Models\Collection::class, function (Faker\Generator $faker) {
  return [
    'id' => $faker->randomNumber(),
    'name' => $faker->name,
  ];
});

$factory->define(Jitterbug\Models\CollectionType::class, function (Faker\Generator $faker) {
  return [
    'id' => $faker->randomNumber(),
    'name' => $faker->word,
  ];
});

$factory->define(Jitterbug\Models\Cut::class, function (Faker\Generator $faker) {
  return [
    'call_number' => function () {
      return factory(Jitterbug\Models\AudioVisualItem::class)->create()->id;
    },
    'cut_number' => $faker->randomNumber(),
    'preservation_master_id' => function () {
      return factory(Jitterbug\Models\PreservationMaster::class)->create()->id;
    },
    'transfer_id' => function () {
      return factory(Jitterbug\Models\Transfer::class)->create()->id;
    },
    'side' => $faker->word,
    'performer_composer' => $faker->word,
    'title' => $faker->word,
    'pm_start_time' => $faker->word,
  ];
});

$factory->define(Jitterbug\Models\Department::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
  ];
});

$factory->define(Jitterbug\Models\FilmItem::class, function (Faker\Generator $faker) {
  return [
    'call_number' => $faker->word,
    'can_number' => $faker->randomNumber(),
    'length_in_feet' => $faker->randomNumber(),
    'film_stock' => $faker->word,
    'element' => $faker->word,
    'color' => $faker->word,
    'base' => $faker->word,
    'sound_type' => $faker->word,
    'edge_code' => $faker->word,
    'shrinkage_percent' => $faker->word,
    'condition' => $faker->word,
    'content_description' => $faker->text,
  ];
});

$factory->define(Jitterbug\Models\FilmMaster::class, function (Faker\Generator $faker) {
  return [
    'frame_size' => $faker->word,
    'aspect_ratio' => $faker->word,
  ];
});

$factory->define(Jitterbug\Models\Format::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->word,
    'prefix' => 'FS',
    'legacy_prefix' => $faker->word,
  ];
});

$factory->define(Jitterbug\Models\ImportTransaction::class, function (Faker\Generator $faker) {
  return [
    'transaction_id' => $faker->word,
    'import_type' => $faker->word,
  ];
});

$factory->define(Jitterbug\Models\LegacyCallNumberSequence::class, function (Faker\Generator $faker) {
  return [
    'prefix' => $faker->word,
    'next' => $faker->randomNumber(),
    'reserved' => $faker->word,
  ];
});

$factory->define(Jitterbug\Models\Mark::class, function (Faker\Generator $faker) {
  return [
    'user_id' => $faker->randomNumber(),
    'markable_type' => $faker->word,
    'markable_id' => $faker->randomNumber(),
  ];
});

$factory->define(Jitterbug\Models\NewCallNumberSequence::class, function (Faker\Generator $faker) {
  return [
    'prefix' => $faker->word,
    'collection_id' => function () {
      return factory(Jitterbug\Models\Collection::class)->create()->id;
    },
    'next' => $faker->randomNumber(),
    'reserved' => $faker->word,
  ];
});

$factory->define(Jitterbug\Models\PlaybackMachine::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
  ];
});

$factory->define(Jitterbug\Models\PmSpeed::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
  ];
});

$factory->define(Jitterbug\Models\Prefix::class, function (Faker\Generator $faker) {
  return [
    'label' => $faker->name,
    'collection_type_id' => $faker->randomNumber(),
  ];
});

$factory->define(Jitterbug\Models\PreservationMaster::class, function (Faker\Generator $faker) {
  return [
    'call_number' => function () {
      return factory(Jitterbug\Models\AudioVisualItem::class)->create()->id;
    },
    'checksum' => $faker->word,
    'project_id' => function () {
      return factory(Jitterbug\Models\Project::class)->create()->id;
    },
    'reproduction_machine_id' => function () {
      return factory(Jitterbug\Models\ReproductionMachine::class)->create()->id;
    },
    'department_id' => function () {
      return factory(Jitterbug\Models\Department::class)->create()->id;
    },
    'duration_in_seconds' => $faker->randomNumber(),
    'file_name' => $faker->word,
    'file_location' => $faker->word,
    'file_size_in_bytes' => $faker->randomNumber(),
    'file_format' => $faker->word,
    'file_codec' => $faker->word,
    'access_file_location' => $faker->word,
    'subclass_type' => $faker->word,
    'subclass_id' => $faker->randomNumber(),
  ];
});

$factory->define(Jitterbug\Models\PreservationMasterCollection::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
    'count' => $faker->randomNumber(),
  ];
});

$factory->define(Jitterbug\Models\PreservationMasterDepartment::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
    'count' => $faker->randomNumber(),
  ];
});

$factory->define(Jitterbug\Models\PreservationMasterFormat::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
    'count' => $faker->randomNumber(),
  ];
});

$factory->define(Jitterbug\Models\PreservationMasterType::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
    'count' => $faker->randomNumber(),
  ];
});

$factory->define(Jitterbug\Models\Project::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
  ];
});

$factory->define(Jitterbug\Models\ReproductionMachine::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
  ];
});

$factory->define(Jitterbug\Models\SamplingRate::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
  ];
});

$factory->define(Jitterbug\Models\TapeBrand::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
  ];
});

$factory->define(Jitterbug\Models\Transfer::class, function (Faker\Generator $faker) {
  return [
    'preservation_master_id' => function () {
      return factory(Jitterbug\Models\PreservationMaster::class)->create()->id;
    },
    'call_number' => function () {
      return factory(Jitterbug\Models\AudioVisualItem::class)->create()->id;
    },
    'transfer_date' => $faker->date(),
    'playback_machine_id' => function () {
      return factory(Jitterbug\Models\PlaybackMachine::class)->create()->id;
    },
    'engineer_id' => function () {
      return factory(Jitterbug\Models\User::class)->create()->id;
    },
    'vendor_id' => function () {
      return factory(Jitterbug\Models\Vendor::class)->create()->id;
    },
    'condition_note' => $faker->text,
    'transfer_note' => $faker->text,
    'subclass_type' => $faker->word,
    'subclass_id' => $faker->randomNumber(),
  ];
});

$factory->define(Jitterbug\Models\TransferCollection::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
    'count' => $faker->randomNumber(),
  ];
});

$factory->define(Jitterbug\Models\TransferFormat::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
    'count' => $faker->randomNumber(),
  ];
});

$factory->define(Jitterbug\Models\TransferType::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
    'count' => $faker->randomNumber(),
  ];
});

$factory->define(Jitterbug\Models\User::class, function (Faker\Generator $faker) {
  return [
    'first_name' => $faker->firstName,
    'middle_name' => $faker->word,
    'last_name' => $faker->lastName,
    'email' => $faker->safeEmail,
    'username' => $faker->userName,
    'password' => bcrypt($faker->password),
    'admin' => $faker->boolean,
    'remember_token' => str_random(10),
    'legacy_initials' => $faker->word,
  ];
});

$factory->define(Jitterbug\Models\Vendor::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
  ];
});

$factory->define(Jitterbug\Models\VideoItem::class, function (Faker\Generator $faker) {
    return [
        'call_number' => $faker->word,
        'mono_stereo' => $faker->word,
        'element' => $faker->word,
        'color' => $faker->word,
        'recording_standard' => $faker->word,
        'content_description' => $faker->text,
    ];
});

$factory->define(Jitterbug\Models\VideoMaster::class, function (Faker\Generator $faker) {
    return [
        'frame_size' => $faker->word,
        'aspect_ratio' => $faker->word,
    ];
});

$factory->define(Jitterbug\Models\VideoTransfer::class, function (Faker\Generator $faker) {
    return [
        'time_base_corrector' => $faker->word,
        'ad_converter' => $faker->word,
    ];
});
