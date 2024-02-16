<?php

namespace App;

use App\Enums\TechnologyEra;
use App\Enums\UnitArmorCategory;
use App\Enums\UnitEquipmentCategory;
use App\Enums\UnitEquipmentClass;
use App\Enums\UnitPlatformCategory;
use App\UnitArmor\NoArmor;
use App\UnitArmor\Person\BronzePlate;
use App\UnitArmor\Person\IronPlate;
use App\UnitArmor\Person\SteelPlate;
use App\UnitArmor\Stealth\AdvancedStealth;
use App\UnitArmor\Stealth\Camouflage;
use App\UnitArmor\UnitArmorType;
use App\UnitArmor\Vehicle\CompositeArmor;
use App\UnitArmor\Vehicle\HeavyArmor;
use App\UnitArmor\Vehicle\Multideck;
use App\UnitArmor\Vehicle\PointDefense;
use App\UnitArmor\Vehicle\SteelArmor;
use App\UnitEquipment\AirGun\AirAiMissile;
use App\UnitEquipment\AirGun\AirGuidedMissile;
use App\UnitEquipment\AirGun\AirHomingMissile;
use App\UnitEquipment\AirGun\AirMachineGun;
use App\UnitEquipment\AntiAir\AiMissile;
use App\UnitEquipment\AntiAir\AntiAirGun;
use App\UnitEquipment\AntiAir\GuidedMissile;
use App\UnitEquipment\AntiAir\HomingMissile;
use App\UnitEquipment\AntiTank\AntiTankMissile;
use App\UnitEquipment\AntiTank\AntiTankRifle;
use App\UnitEquipment\AntiTank\RocketGrenade;
use App\UnitEquipment\AntiTankGun\AntiTankGun;
use App\UnitEquipment\Bomb\AiGuidedBomb;
use App\UnitEquipment\Bomb\GuidedBomb;
use App\UnitEquipment\Bomb\HeavyBomb;
use App\UnitEquipment\Bomb\LightBomb;
use App\UnitEquipment\Building\Excavator;
use App\UnitEquipment\Building\Tractor;
use App\UnitEquipment\Firearm\AssaultRifle;
use App\UnitEquipment\Firearm\FlintlockMusket;
use App\UnitEquipment\Firearm\LaserRifle;
use App\UnitEquipment\Firearm\RepeatingRifle;
use App\UnitEquipment\Firearm\RifleMusket;
use App\UnitEquipment\Firearm\ScopeRifle;
use App\UnitEquipment\FlightDeck\AiRadarDeck;
use App\UnitEquipment\FlightDeck\CatapultDeck;
use App\UnitEquipment\FlightDeck\RadarDeck;
use App\UnitEquipment\FlightDeck\WoodenDeck;
use App\UnitEquipment\Melee\BronzeSword;
use App\UnitEquipment\Melee\IronSword;
use App\UnitEquipment\Melee\Rapier;
use App\UnitEquipment\Melee\SteelSword;
use App\UnitEquipment\Melee\StoneAxe;
use App\UnitEquipment\MissileBay\MissileBay;
use App\UnitEquipment\NavalAssault\Buccaneers;
use App\UnitEquipment\NavalAssault\RaidingParty;
use App\UnitEquipment\Ranged\Bow;
use App\UnitEquipment\RocketArtillery\AiRocketSystem;
use App\UnitEquipment\RocketArtillery\RocketSystem;
use App\UnitEquipment\Skirmish\BronzeThrowingSpear;
use App\UnitEquipment\Skirmish\Crossbow;
use App\UnitEquipment\Skirmish\IronThrowingSpear;
use App\UnitEquipment\Skirmish\WoodThrowingSpear;
use App\UnitEquipment\SkirmishFirearm\Arquebus;
use App\UnitEquipment\SkirmishFirearm\FlintlockCarbine;
use App\UnitEquipment\SkirmishFirearm\RifleCarbine;
use App\UnitEquipment\Spear\BronzeSpear;
use App\UnitEquipment\Spear\Halberd;
use App\UnitEquipment\Spear\IronSpear;
use App\UnitEquipment\Spear\Lance;
use App\UnitEquipment\Spear\Pike;
use App\UnitEquipment\Spear\WoodSpear;
use App\UnitEquipment\Trade\CargoHold;
use App\UnitEquipment\Trade\ContainerHold;
use App\UnitEquipment\UnitEquipmentType;
use App\UnitPlatforms\Air\AttackHelicopter;
use App\UnitPlatforms\Air\Helicopter;
use App\UnitPlatforms\Missile\CruiseMissile;
use App\UnitPlatforms\Missile\HypersonicMissile;
use App\UnitPlatforms\Missile\ICBM;
use App\UnitPlatforms\Mounted\SaddledHorse;
use App\UnitPlatforms\Naval\CarvelHull;
use App\UnitPlatforms\Naval\ClinkerHull;
use App\UnitPlatforms\Naval\DieselElectric;
use App\UnitPlatforms\Naval\FullRigged;
use App\UnitPlatforms\Naval\HeavyGalley;
use App\UnitPlatforms\Naval\NuclearEngine;
use App\UnitPlatforms\Naval\SteamEngine;
use App\UnitPlatforms\Person;
use App\UnitPlatforms\UnitPlatformType;
use App\UnitPlatforms\Vehicle\Carriage;
use App\UnitPlatforms\Vehicle\Motorized;
use App\UnitPlatforms\Vehicle\Tracked;

class UnitName
{
    public static function all(): array
    {
        $names = [];

        foreach (UnitPlatformType::all() as $platform) {
            foreach ($platform->equipment() as $equipment) {
                foreach ($platform->armors()->all() ?: [NoArmor::get()] as $armor) {
                    if (!isset($names["$platform, $equipment, $armor"]) &&
                        $platform->canHave($equipment, $armor)
                    ) {
                        $names["$platform, $equipment, $armor"] = self::name($platform, $equipment, $armor);
                    }
                }
            }
        }

        ksort($names);

        return $names;
    }

    public static function name(
        UnitPlatformType  $platform,
        UnitEquipmentType $equipment,
        ?UnitArmorType    $armor,
        string            $style = 'default'
    ): string
    {
        if ($armor === NoArmor::get()) {
            $armor = null;
        }

        if ($platform->category()->is(UnitPlatformCategory::Air, UnitPlatformCategory::Missile)) {
            return self::airName($platform, $equipment, $armor, $style);
        }
        if ($platform->category() === UnitPlatformCategory::Naval) {
            return self::navalName($platform, $equipment, $armor, $style);
        }
        if ($platform->category() === UnitPlatformCategory::Vehicle) {
            return self::vehicleName($platform, $equipment, $armor, $style);
        }


        $names = static::names();

        $nameParts = [];

        // Armor name
        switch (true) {
            case !$armor:
                break;
            default:
                $nameParts[1] = $armor->name();
        }

        // Platform name
        switch (true) {
            case $platform->is(Person::get()):
                break;

            case $platform->category() == UnitPlatformCategory::Space;
                $nameParts[4] = $platform->name();
                break;
            default:
                $nameParts[2] = $platform->name();
        }

        // Equipment Name
        $nameParts[3] = $equipment->name();

        ksort($nameParts);

        $name = implode(
            ' ',
            array_map(
                fn(string $namePart) => $names[$style][$namePart] ?? $names['default'][$namePart] ?? $namePart,
                $nameParts
            )
        );

        return $names[$style][$name] ?? $names['default'][$name] ?? $name;
    }

    protected static function airName(
        UnitPlatformType  $platform,
        UnitEquipmentType $equipment,
        ?UnitArmorType    $armor,
        string            $style = 'default'
    ): string
    {
        $nameParts = [];

        // 1) Armor, Stealth is special
        if ($armor && $armor->category() !== UnitArmorCategory::Stealth) {
            $nameParts[] = $armor->name();
        }

        // Helicopters & Missiles are special
        if ($platform->is(
            Helicopter::get(), AttackHelicopter::get(), CruiseMissile::get(), HypersonicMissile::get(), ICBM::get()
        )) {
            // 2) Equipment
            $nameParts[] = $equipment->name();

            // Stealth is special
            if ($armor?->category() === UnitArmorCategory::Stealth) {
                $nameParts[] = $armor->name();
            }

            // 3) Platform
            $nameParts[] = $platform->name();
        } else {
            // 2) Platform
            $nameParts[] = $platform->name();

            // Stealth is special
            if ($armor?->category() === UnitArmorCategory::Stealth) {
                $nameParts[] = $armor->name();
            }

            // 3) Equipment
            $nameParts[] = $equipment->name();
        }

        $names = static::names();

        $name = implode(
            ' ',
            array_filter(array_map(
                fn(string $namePart) => $names[$style][$namePart] ?? $names['default'][$namePart] ?? $namePart,
                $nameParts
            ))
        );

        return $names[$style][$name] ?? $names['default'][$name] ?? $name;
    }

    protected static function names(): array
    {
        return [
            'default' => [
                SteelArmor::get()->name() => 'Armored',
                HeavyArmor::get()->name() => 'Heavy',
                CompositeArmor::get()->name() => 'Composite',
                PointDefense::get()->name() => 'PD',
                AdvancedStealth::get()->name() => 'Adv. Stealth',

                AntiAirGun::get()->name() => 'AA Gun',
                HomingMissile::get()->name() => 'Homing SAM',
                GuidedMissile::get()->name() => 'Guided SAM',
                AiMissile::get()->name() => 'AI SAM',

                RocketSystem::get()->name() => 'MLRS',
                AiRocketSystem::get()->name() => 'AI MLRS',

                AirMachineGun::get()->name() => 'Fighter',
                AirHomingMissile::get()->name() => 'Early Missile Fighter',
                AirGuidedMissile::get()->name() => 'Adv Missile Fighter',
                AirAiMissile::get()->name() => 'AI Missile Fighter',

                LightBomb::get()->name() => 'Light Bomber',
                HeavyBomb::get()->name() => 'Heavy Bomber',
                GuidedBomb::get()->name() => 'Guided Bomber',
                AiGuidedBomb::get()->name() => 'AI Bomber',

                'Biplane Fighter' => '1915 Biplane',
                'Biplane Light Bomber' => '1915 Great War Bomber',

                'Monocoque Fighter' => '1930 Light Fighter',
                'Sealing Tanks Monocoque Fighter' => '1940 Fighter',

                'Monocoque Light Bomber' => '1930 Light Bomber',
                'Sealing Tanks Monocoque Light Bomber' => '1935 Medium Bomber',
                'Monocoque Heavy Bomber' => '1940 Heavy Bomber',

                'Sealing Tanks Supersonic Early Missile Fighter' => '1950 Jet Fighter',
                'Chaff Flare Supersonic Early Missile Fighter' => '1960 Jet Fighter',
                'Chaff Flare Supersonic Adv Missile Fighter' => '1965 Jet Fighter',

                'Sealing Tanks Supersonic Heavy Bomber' => '1950 Jet Bomber',
                'Sealing Tanks Supersonic Guided Bomber' => '1955 Jet Bomber',
                'Chaff Flare Supersonic Heavy Bomber' => '1960 Jet Bomber',
                'Chaff Flare Supersonic Guided Bomber' => '1965 Jet Bomber',

                'Chaff Flare Fly By Wire Early Missile Fighter' => '1970 Jet Fighter',
                'Chaff Flare Fly By Wire Adv Missile Fighter' => '1975 Jet Fighter',
                'Radar Jamming Fly By Wire Early Missile Fighter' => '1980 Jet Fighter',
                'Radar Jamming Fly By Wire Adv Missile Fighter' => '1985 Jet Fighter',
                'Fly By Wire Stealth Early Missile Fighter' => '1980 Stealth Fighter',
                'Fly By Wire Stealth Adv Missile Fighter' => '1990 Stealth Fighter',

                'Chaff Flare Fly By Wire Heavy Bomber' => '1970 Jet Bomber',
                'Chaff Flare Fly By Wire Guided Bomber' => '1980 Jet Bomber',
                'Radar Jamming Fly By Wire Guided Bomber' => '1990 Jet Bomber',
                'Fly By Wire Stealth Guided Bomber' => '1990 Stealth Bomber',

                'Radar Jamming Supermanouverable Adv Missile Fighter' => '1990 Jet Fighter',
                'Supermanouverable Stealth Adv Missile Fighter' => '2010 Stealth Fighter',
                'Supermanouverable Adv. Stealth Adv Missile Fighter' => '2030 Stealth Fighter',
                'Supermanouverable Adv. Stealth AI Missile Fighter' => '2050 Stealth Fighter',

                'Sealing Tanks Heavy Bomber Helicopter' => '1950 Helicopter',
                'Sealing Tanks Guided Bomber Helicopter' => '1955 Helicopter',
                'Chaff Flare Heavy Bomber Helicopter' => '1960 Helicopter',
                'Chaff Flare Guided Bomber Helicopter' => '1965 Helicopter',

                'Chaff Flare Heavy Bomber Attack Helicopter' => '1970 Attack Helicopter',
                'Chaff Flare Guided Bomber Attack Helicopter' => '1980 Attack Helicopter',
                'Radar Jamming Guided Bomber Attack Helicopter' => '1990 Attack Helicopter',
                'Guided Bomber Stealth Attack Helicopter' => '2000 Stealth Helicopter',
                'AI Bomber Adv. Stealth Attack Helicopter' => '2040 Stealth Helicopter',

                'Light Bomber Cruise Missile' => 'Early Cruise Missile',
                'Heavy Bomber Cruise Missile' => 'Cruise Missile',
                'Guided Bomber Cruise Missile' => 'Guided Missile',

                'Guided Bomber Hypersonic Missile' => 'Hypersonic Missile',
                'AI Bomber Hypersonic Missile' => 'AI Hypersonic Missile',

                'Heavy Bomber ICBM' => 'ICBM',
                'Guided Bomber ICBM' => 'Guided ICBM',
                'AI Bomber ICBM' => 'AI ICBM',

                RaidingParty::get()->name() => 'Raiding',
                Buccaneers::get()->name() => 'Buccaneer',

                MissileBay::get()->name() => 'Missile',
                WoodenDeck::get()->name() => '',
                CatapultDeck::get()->name() => 'Catapult',
                RadarDeck::get()->name() => 'Radar',
                AiRadarDeck::get()->name() => 'AI',

                CargoHold::get()->name() => 'Cargo',
                ContainerHold::get()->name() => 'Container',

                // Clinker
                'Steel Ram Heavy Galleass' => 'Heavy Ram Galleass',
                'Steel Ram Galleass' => 'Ram Galleass',
                'Onager Heavy Galleass' => 'Early Heavy Galleass',
                'Onager Galleass' => 'Early Galleass',
                'Trebuchet Heavy Galleass' => 'Heavy Galleass',
                'Trebuchet Galleass' => 'Galleass',

                // Carvel
                'Bombard Galleon' => 'Galleon',
                'Bombard Caravel' => 'Caravel',
                'Privateer Bombard Galleon' => 'Privateer Caravel',

                'Cannon Galleon' => 'War Galleon',
                'Cannon Caravel' => 'War Caravel',
                'Privateer Cannon Galleon' => 'Privateer Galleon',

                // Full-Rigged
                'Bombard Ship-of-the-Line' => 'Man-o-War',
                'Bombard Frigate' => 'Pinnace',
                'Privateer Bombard Ship-of-the-Line' => 'Privateer Pinnace',

                'Cannon Frigate' => 'Frigate',
                'Cannon Ship-of-the-Line' => 'Ship-of-the-Line',
                'Ironclad Cannon Ship-of-the-Line' => 'Armored Frigate',
                'Privateer Cannon Ship-of-the-Line' => 'Privateer Frigate',

                'Buccaneers Barque' => 'War Barque',
                'Musket Marines Frigate' => 'Brig',

                // Steam Engine
                'Musket Marines Gunboat' => 'Assault Steamer',

                'Cannon Gunboat' => 'Steam Frigate',
                'Cannon Steam Cruiser' => 'Steam Ship-of-the-Line',
                'Ironclad Cannon Steam Cruiser' => 'Armored Steam Frigate',

                'Artillery Gunboat' => 'Gunboat',
                'Artillery Steam Cruiser' => 'Steam Cruiser',
                'Ironclad Artillery Steam Cruiser' => 'Armored Cruiser',
                'Armored Artillery Steam Cruiser' => 'Steam Battleship',

                'Howitzer Gunboat' => 'Coastal Defence Ship',
                'Howitzer Steam Cruiser' => 'Pocket Battleship',
                'Armored Howitzer Steam Cruiser' => 'Dreadnought',

                'Torpedo Gunboat' => 'Torpedo Steamer',

                // Diesel-Electric
                'Torpedo Destroyer' => 'Torpedo Boat',
                'Homing Torpedo Destroyer' => 'Homing Torpedo Boat',
                'Guided Torpedo Destroyer' => 'Guided Torpedo Boat',
                'AI Torpedo Destroyer' => 'AI Torpedo Boat',

                'Artillery Destroyer' => 'Destroyer',
                'Armored Artillery Cruiser' => 'Cruiser',
                'Heavy Artillery Cruiser' => 'Heavy Cruiser',

                'Howitzer Destroyer' => 'Adv. Destroyer',
                'Armored Howitzer Cruiser' => 'Battle Cruiser',
                'Heavy Howitzer Cruiser' => 'Battleship',

                'Armored Carrier' => 'Carrier',
                'Armored Catapult Carrier' => 'Catapult Carrier',

                'Pioneer Ship' => 'Migrant Ship',

                // Nuclear Engine
                'Heavy Howitzer Nuclear Cruiser' => 'Nuclear Cruiser',
                'Heavy Catapult Nuclear Carrier' => 'Nuclear Carrier',

                // Submarine
                'Torpedo Submarine' => 'Submarine',
                'Torpedo Electric Submarine' => 'Electric Submarine',

                BronzePlate::get()->name() => 'Bronze',
                IronPlate::get()->name() => 'Iron',
                SteelPlate::get()->name() => 'Plated',
                Camouflage::get()->name() => 'Camo',

                SaddledHorse::get()->name() => 'Horse',
                Motorized::get()->name() => 'Truck',

                StoneAxe::get()->name() => 'Warrior',
                BronzeSword::get()->name() => 'Swordsman',
                IronSword::get()->name() => 'Legion',
                SteelSword::get()->name() => 'Longswordsman',
                'Plated Longswordsman' => 'Foot Knight',
                'Plated Horse Longswordsman' => 'Horse Knight',
                Rapier::get()->name() => 'Man-at-Arms',
                FlintlockMusket::get()->name() => 'Musketeer',
                RifleMusket::get()->name() => 'Fusilier',
                RepeatingRifle::get()->name() => 'Infantry',
                AssaultRifle::get()->name() => 'General Infantry',
                ScopeRifle::get()->name() => 'Modern Infantry',
                LaserRifle::get()->name() => 'Laser Infantry',

                WoodSpear::get()->name() => 'Warband',
                BronzeSpear::get()->name() => 'Spearman',
                IronSpear::get()->name() => 'Hoplite',
                Lance::get()->name() => 'Lanceman',
                Halberd::get()->name() => 'Halberdier',
                Pike::get()->name() => 'Pikeman',

                Bow::get()->name() => 'Bowman',
                WoodThrowingSpear::get()->name() => 'Scout',
                BronzeThrowingSpear::get()->name() => 'Skirmisher',
                IronThrowingSpear::get()->name() => 'Peltast',
                Crossbow::get()->name() => 'Crossbowman',
                Arquebus::get()->name() => 'Arquebusier',
                'Horse Arquebusier' => 'Harquebusier',
                FlintlockCarbine::get()->name() => 'Light Musketman',
                'Horse Light Musketman' => 'Dragoon',
                RifleCarbine::get()->name() => 'Carabinier',

                AntiTankRifle::get()->name() => 'AT Rifle',
                RocketGrenade::get()->name() => 'AT Rocket',
                AntiTankMissile::get()->name() => 'AT Missile',

                AntiTankGun::get()->name() => 'AT Gun',

                'AT Gun Tank' => '1930 Light Tank',
                'Armored AT Gun Tank' => '1935 Medium Tank',
                'Heavy AT Gun Tank' => '1945 Heavy Tank',

                'High Velocity Gun Tank' => '1950 Tank Destroyer',
                'Heavy High Velocity Gun Tank' => '1950 Main Battle Tank',
                'Composite High Velocity Gun Tank' => '1965 Main Battle Tank',

                'Smooth Bore Gun Tank' => '1980 Light Tank',
                'Composite Smooth Bore Gun Tank' => '1990 Main Battle Tank',
            ]
        ];
    }

    protected static function navalName(
        UnitPlatformType  $platform,
        UnitEquipmentType $equipment,
        ?UnitArmorType    $armor,
        string            $style = 'default'
    ): string
    {
        $nameParts = [];

        // 1) Armor
        if ($armor && $armor !== Multideck::get()) {
            $nameParts[] = $armor->name();
        }

        // 2) Equipment
        $nameParts[] = $equipment->name();

        // 3) Nuclear is special
        if ($platform === NuclearEngine::get()) {
            $nameParts[] = 'Nuclear';
        }

        // 4) Heavy Galleys are special
        if ($platform === HeavyGalley::get()) {
            $nameParts[] = match (true) {
                $equipment->category()->class() === UnitEquipmentClass::NonCombat => 'Monoreme',

                $equipment->technology()?->era() === TechnologyEra::Medieval,
                    $equipment->technology()?->era() === TechnologyEra::HighMedieval,
                    $equipment->technology()?->era() === TechnologyEra::Classical => $armor?->weight
                    ? 'Quinquereme'
                    : 'Quadrireme',

                default => $armor?->weight
                    ? 'Trireme'
                    : 'Bireme',
            };
        }

        // 5) Platform
        $nameParts[] = match (true) {
            // Carriers are special
            $equipment->category() === UnitEquipmentCategory::FlightDeck => 'Carrier',

            // Nuclear is special
            $platform === NuclearEngine::get() => 'Cruiser',

            // Heavy Galleys are special
            $platform === HeavyGalley::get() => '',

            $platform === ClinkerHull::get() => $armor
                ? 'Heavy Galleass'
                : (
                $equipment->category()->class() === UnitEquipmentClass::NonCombat
                    ? 'Cog'
                    : 'Galleass'
                ),
            $platform === CarvelHull::get() => $armor
                ? 'Galleon'
                : (
                $equipment->category()->class() === UnitEquipmentClass::NonCombat
                    ? 'Carrack'
                    : 'Caravel'
                ),

            $platform === FullRigged::get() => $armor
                ? 'Ship-of-the-Line'
                : (
                $equipment->category()->class() === UnitEquipmentClass::NonCombat
                    ? 'Barque'
                    : 'Frigate'
                ),

            $platform === SteamEngine::get() => $armor
                ? 'Steam Cruiser'
                : (
                $equipment->category()->class() === UnitEquipmentClass::NonCombat
                    ? 'Steamer'
                    : 'Gunboat'
                ),

            $platform === DieselElectric::get() => $armor
                ? 'Cruiser'
                : (
                $equipment->category()->class() === UnitEquipmentClass::NonCombat
                    ? 'Ship'
                    : 'Destroyer'
                ),

            default => $platform->name(),
        };

        $names = static::names();

        $name = implode(
            ' ',
            array_filter(array_map(
                fn(string $namePart) => $names[$style][$namePart] ?? $names['default'][$namePart] ?? $namePart,
                $nameParts
            ))
        );

        return $names[$style][$name] ?? $names['default'][$name] ?? $name;
    }

    protected static function vehicleName(
        UnitPlatformType  $platform,
        UnitEquipmentType $equipment,
        ?UnitArmorType    $armor,
        string            $style = 'default'
    ): string
    {
        $nameParts = [];

        // 1) Armor
        if ($armor) {
            $nameParts[] = $armor->name();
        }

        // Motorized Civilians & Tracked AT Guns are special
        if ($platform === Motorized::get() && $equipment->category()->class() === UnitEquipmentClass::NonCombat ||
            $platform === Tracked::get() && $equipment->category() === UnitEquipmentCategory::AntiTankGun
        ) {
            // 2) Equipment
            $nameParts[] = $equipment->name();

            // 3) Platform
            $nameParts[] = $platform === Tracked::get()
                ? 'Tank'
                : $platform->name();
        } else {
            // 2) Platform
            $nameParts[] = match (true) {
                $equipment->is(Excavator::get(), Tractor::get()),
                    $platform === Carriage::get() => '',

                $platform === Motorized::get() => 'Mot.',

                default => $platform->name(),
            };

            // 3) Equipment
            $nameParts[] = $equipment->name();
        }

        $names = static::names();

        $name = implode(
            ' ',
            array_filter(array_map(
                fn(string $namePart) => $names[$style][$namePart] ?? $names['default'][$namePart] ?? $namePart,
                $nameParts
            ))
        );

        return $names[$style][$name] ?? $names['default'][$name] ?? $name;
    }
}
