<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectMeasuresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $measures = [
            "Chillers",	
            "Flue Gas Recovery Devices",	
            "Gas Fired Condensing Boilers",	
            "Heating System Insulation",	
            "Heating, hot water system, air conditioning and ventilation Controls",		
            "Mechanical Ventilation and Heat Recovery",	
            "Oil Fired Condensing Boilers",	
            "Radiant Heating (non-domestic)",	
            "Underfloor Heating",	
            "Warm Air Heating  (domestic and non-domestic)",	
            "Cavity Wall Insulation",	
            "Energy Efficient Glazing & Doors",	
            "Flat Roof Insulation",	
            "Floor Insulation",	
            "Hybrid Wall Insulation",	
            "Room in Roof Insulation",	
            "Solar Blinds & Shutters",	
            "Electric Storage Heaters",	
            "Lighting Controls Non Domestic",	
            "Lighting Fittings, Lighting systems and lighting system controls",	
            "Variable Speed drives for fans and pumps",	
            "Cavity wall insulation including that installed in party walls",	
            "Condensing boilers, natural gas-fired and liquefied petroleum gas-fired",	
            "Condensing boilers, oil-fired",	
            "Electric storage heaters (including electric warm air heating units that incorporate heat storage)",	
            "Energy efficient glazing and doors including replacement insulating glass units (IGU)",	
            "External wall insulation",
            "Flue gas heat recovery devices",	
            "Heating, hot water system, air conditioning or ventilation system controls and components",	
            "Hot water systems",	
            "Internal wall insulation",	
            "Light fittings, lighting systems and lighting system controls",	
            "Loft insulation",	
            "Mechanical ventilation with heat recovery",	
            "Park Homes insulation",	
            "Pitched roof insulation",	
            "Room-in-roof insulation",	
            "Solar blind, shutters and shading devices (internal and external)",	
            "Under-floor heating",	
            "Warm-air heating",	
            "Water efficient taps and showers",	
            "Draught proofing",		
        ];
        foreach ($measures as $measure) {
            DB::table('project_measures')->insert(['name' => $measure]);
        }
    }
}
