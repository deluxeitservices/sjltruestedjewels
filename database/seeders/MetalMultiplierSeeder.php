<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetalMultiplierSeeder extends Seeder {
  public function run(): void {
    $rows = [
      ['key'=>'gold_jewellery',      'multiplier'=>0.99],
      ['key'=>'gold_bar',            'multiplier'=>0.98],
      ['key'=>'gold_coin',           'multiplier'=>0.97],
      ['key'=>'silver_jewellery',    'multiplier'=>0.80],
      ['key'=>'silver_bar',          'multiplier'=>0.92],
      ['key'=>'silver_coin',         'multiplier'=>0.90],
      ['key'=>'platinum_jewellery',  'multiplier'=>0.88],
      ['key'=>'platinum_bar',        'multiplier'=>0.95],
      ['key'=>'platinum_coin',       'multiplier'=>0.94],
      ['key'=>'palladium_jewellery', 'multiplier'=>0.88],
      ['key'=>'palladium_bar',       'multiplier'=>0.95],
      ['key'=>'palladium_coin',      'multiplier'=>0.94],
    ];
    foreach ($rows as $r) {
      DB::table('metal_multipliers')->updateOrInsert(['key'=>$r['key']], ['multiplier'=>$r['multiplier'], 'active'=>1,'updated_at'=>now(), 'created_at'=>now()]);
    }
  }
}
