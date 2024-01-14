<?php

namespace App\Models;

use App\Enums\Armor;
use App\Enums\UnitType;
use App\Enums\Weapon;
use App\Enums\WeaponType;
use App\Managers\UnitManager;
use Database\Factories\UnitFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\Unit
 *
 * @property int $id
 * @property int $hex_id
 * @property int $map_id
 * @property int $player_id
 * @property UnitType $type
 * @property int $health
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Hex $hex
 * @property-read Map $map
 * @property-read Player $player
 * @method static UnitFactory factory($count = null, $state = [])
 * @method static Builder|Unit newModelQuery()
 * @method static Builder|Unit newQuery()
 * @method static Builder|Unit query()
 * @method static Builder|Unit whereCreatedAt($value)
 * @method static Builder|Unit whereHealth($value)
 * @method static Builder|Unit whereHexId($value)
 * @method static Builder|Unit whereId($value)
 * @method static Builder|Unit whereMapId($value)
 * @method static Builder|Unit wherePlayerId($value)
 * @method static Builder|Unit whereType($value)
 * @method static Builder|Unit whereUpdatedAt($value)
 * @property-read string $name
 * @property float $moves_remaining
 * @method static Builder|Unit whereMovesRemaining($value)
 * @method static Builder|Unit whereWeapon($value)
 * @property Weapon|null $weapon
 * @property Armor|null $armor
 * @property-read int $strength
 * @property Carbon|null $deleted_at
 * @method static Builder|Unit onlyTrashed()
 * @method static Builder|Unit whereArmor($value)
 * @method static Builder|Unit whereDeletedAt($value)
 * @method static Builder|Unit withTrashed()
 * @method static Builder|Unit withoutTrashed()
 * @property-read int $cost
 * @property-read int $ranged_strength
 * @mixin \Eloquent
 */
class Unit extends Model
{
    use HasFactory;
    use PohModel;
    use SoftDeletes;

    protected $fillable = [
        'hex_id',
        'map_id',
        'user_id',
        'type',
        'weapon',
        'armor',
        'health',
    ];

    protected $casts = [
        'type' => UnitType::class,
        'armor' => Armor::class,
        'weapon' => Weapon::class,
    ];

    public function hex(): BelongsTo
    {
        return $this->belongsTo(Hex::class);
    }

    public function map(): BelongsTo
    {
        return $this->belongsTo(Map::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function getCostAttribute(): int
    {
        return UnitManager::getCost($this->type, $this->weapon, $this->armor);
    }

    public function getNameAttribute(): string
    {
        $typeName = $this->type->translate();
        $weaponName = $this->weapon?->translate();
        $armorName = $this->armor?->translate();
        $armorName = static::Names[$armorName] ?? $armorName;

        // Worker, Settler, Scout
        if (!$this->weapon) {
            return $this->armor
                ? "{$armorName} {$typeName}"
                : $typeName;
        }

        $name = match ($this->type) {
            UnitType::Ranged,
            => "{$weaponName}man",

            UnitType::Siege,
            => $weaponName,

            UnitType::HorseDrawn,
            => "Horse {$weaponName}",

            UnitType::Mounted, UnitType::Tracked, UnitType::Towed,
            => "{$typeName} {$weaponName}",

            default,
            => "{$weaponName} {$typeName}",
        };

        if ($this->armor) {
            if (isset(static::Names["{$armorName} {$name}"])) {
                return static::Names["{$armorName} {$name}"];
            }
            if (isset(static::Names[$name])) {
                return "$armorName " . static::Names[$name];
            }
            return "{$armorName} {$name}";
        }

        return static::Names[$name] ?? $name;
    }

    public function getRangedStrengthAttribute(Unit $against = null): int
    {
        return (int)$this->weapon?->rangedStrength($against);
    }

    const Names = [
        'Wooden Shield' => 'Shield',
        'Bronze Plate' => 'Bronze',
        'Iron Plate' => 'Iron',
        'Steel Plate' => 'Plated',
        'Camouflage' => 'Camo',
        'Body Armor' => 'Body Armored',
        'Armor' => 'Armored',
        'Heavy Armor' => 'Heavy Armored',

        'Wood Throwing Spear Skirmisher' => 'Hunter',
        'Bronze Throwing Spear Skirmisher' => 'Skirmisher',
        'Iron Throwing Spear Skirmisher' => 'Peltast',
        'Crossbow Skirmisher' => 'Crossbowman',
        'Machine Gun Skirmisher' => 'Machine Gunner',
        'Camo Machine Gun Skirmisher' => 'Machine Gun Nest',

        'Stone Axe Infantry' => 'Axeman',
        'Bronze Sword Infantry' => 'Swordsman',
        'Iron Sword Infantry' => 'Light Legionary',
        'Steel Sword Infantry' => 'Longswordsman',
        'Arquebus Infantry' => 'Arquebusier',
        'Musket Infantry' => 'Musketeer',
        'Rifle Musket Infantry' => 'Rifleman',
        'Repeating Rifle Infantry' => 'Infantry',
        'Assault Rifle Infantry' => 'Assault Infantry',
        'Scope Rifle Infantry' => 'Modern Infantry',
        'Laser Rifle Infantry' => 'Laser Infantry',

        'Wood Spear Infantry' => 'Levy',
        'Bronze Spear Infantry' => 'Spearman',
        'Iron Spear Infantry' => 'Phalanx',
        'Lance Infantry' => 'Lanceman',
        'Halberd Infantry' => 'Halberdier',
        'Pike Infantry' => 'Pikeman',
        'Grenadier Infantry' => 'Grenadier',
        'Anti Tank Rifle Infantry' => 'AT Squad',
        'Rocket Grenade Infantry' => 'RPG Squad',
        'Anti Tank Missile Infantry' => 'AT-Missile Squad',

        'Stone Axe Heavy Infantry' => 'Axeman',
        'Bronze Sword Heavy Infantry' => 'Swordsman',
        'Iron Sword Heavy Infantry' => 'Legionary',
        'Steel Sword Heavy Infantry' => 'Longswordsman',
        'Chainmail Steel Sword Heavy Infantry' => 'Chainmail Foot Knight',
        'Plated Steel Sword Heavy Infantry' => 'Plated Foot Knight',
        'Arquebus Heavy Infantry' => 'Arquebusier',
        'Musket Heavy Infantry' => 'Musketeer',
        'Rifle Musket Heavy Infantry' => 'Rifleman',
        'Repeating Rifle Heavy Infantry' => 'Infantry',
        'Assault Rifle Heavy Infantry' => 'Assault Infantry',
        'Scope Rifle Heavy Infantry' => 'Modern Infantry',
        'Laser Rifle Heavy Infantry' => 'Laser Infantry',

        'Wood Spear Heavy Infantry' => 'Levy',
        'Bronze Spear Heavy Infantry' => 'Spearman',
        'Iron Spear Heavy Infantry' => 'Phalanx',
        'Lance Heavy Infantry' => 'Lanceman',
        'Halberd Heavy Infantry' => 'Halberdier',
        'Pike Heavy Infantry' => 'Pikeman',
        'Grenadier Heavy Infantry' => 'Grenadier',
        'Anti Tank Rifle Heavy Infantry' => 'AT Squad',
        'Rocket Grenade Heavy Infantry' => 'RPG Squad',
        'Anti Tank Missile Heavy Infantry' => 'AT-Missile Squad',

        'Slingman' => 'Slinger',
        'Composite Bowman' => 'Archer',
        'Mortarman' => 'Mortar Team',

        'Mounted Stone Axe' => 'Rider',
        'Mounted Bronze Sword' => 'Horse Swordsman',
        'Mounted Iron Sword' => 'Horse Legionary',
        'Mounted Steel Sword' => 'Horse Longswordsman',
        'Chainmail Mounted Steel Sword' => 'Chainmail Horse Knight',
        'Plated Mounted Steel Sword' => 'Plated Horse Knight',
        'Mounted Arquebus' => 'Harquebusier',
        'Mounted Musket' => 'Dragoon',
        'Plated Mounted Musket' => 'Cuirassier',
        'Mounted Rifle Musket' => 'Cavalry',
        'Mounted Repeating Rifle' => 'Mounted Infantry',

        'Mounted Wood Spear' => 'Chariot',
        'Mounted Bronze Spear' => 'Equites',
        'Mounted Iron Spear' => 'Horseman',
        'Chainmail Mounted Iron Spear' => 'Cataphract',
        'Mounted Lance' => 'Lancer',
        'Mounted Halberd' => 'Horse Halberdier',
        'Mounted Pike' => 'Hussar',
        'Mounted Grenadier' => 'Carabiner',
        'Mounted Anti Tank Rifle' => 'Mounted AT Squad',
        'Mounted Rocket Grenade' => 'Mounted RPG Squad',

        'Mounted Sling' => 'Chariot Slinger',
        'Mounted Bow' => 'Chariot Archer',
        'Mounted Composite Bow' => 'Horse Archer',
        'Mounted Longbow' => 'Horse Longbowman',
        'Mounted Mortar' => 'Mounted Mortar Team',

        'Mounted Wood Throwing Spear' => 'Chariot Skirmisher',
        'Mounted Bronze Throwing Spear' => 'Horse Skirmisher',
        'Mounted Iron Throwing Spear' => 'Horse Peltast',
        'Mounted Crossbow' => 'Horse Crossbowman',
        'Mounted Machine Gun' => 'Mounted Machine Gunner',

        'Ironclad Tracked Anti Tank Gun' => 'Landship',
        'Armored Tracked Anti Tank Gun' => 'Tank',
        'Heavy Armored Tracked Anti Tank Gun' => 'Heavy Tank',
        'Armored Tracked High Velocity Gun' => "1950's Main Battle Tank",
        'Heavy Armored Tracked High Velocity Gun' => "1960's Main Battle Tank",
        'Composite Armor Tracked High Velocity Gun' => "Composite 1960's Main Battle Tank",
        'Heavy Armored Tracked Smooth Bore Gun' => "1980's Main Battle Tank",
        'Composite Armor Tracked Smooth Bore Gun' => "Composite 1980's Main Battle Tank",
        'Active Defense Tracked Smooth Bore Gun' => "2010's Main Battle Tank",

        "Towed Rocket System" => "Towed MLRS",
        "Stealth Towed Rocket System" => "Stealth MLRS",

        'Ironclad Tracked Artillery' => 'Light Armored Artillery',
        'Armored Tracked Artillery' => 'Armored Artillery',
        'Ironclad Tracked Howitzer' => 'Light Armored Howitzer',
        'Armored Tracked Howitzer' => 'Armored Howitzer',
        'Heavy Armored Tracked Howitzer' => 'Heavy Armored Howitzer',
        'Ironclad Tracked Rocket Artillery' => 'Light Armored Rocket Artillery',
        'Armored Tracked Rocket Artillery' => 'Armored Rocket Artillery',
        'Heavy Armored Tracked Rocket Artillery' => 'Heavy Armored Rocket Artillery',
        'Heavy Armored Tracked Rocket System' => 'Heavy Armored MLRS',
        'Composite Armor Tracked Rocket System' => 'Composite MLRS',
        'Active Defense Tracked Rocket System' => 'Active Defense MLRS',

        'Ram Ship' => 'Galley',
        'Catapult Ship' => 'Trireme',
        'Onager Ship' => 'Quadreme',
        'Trebuchet Ship' => 'Galleass',
        'Bombard Ship' => 'Caravel',
        'Cannon Ship' => 'Frigate',
        'Artillery Ship' => 'Gunboat',
        'Camouflaged Artillery Ship' => 'Dazzle Gunboat',
        'Howitzer Ship' => 'Destroyer',
        'Camouflaged Howitzer Ship' => 'Dazzle Destroyer',
        'Rocket Artillery Ship' => 'Corvette',
        'Camouflaged Rocket Artillery Ship' => 'Dazzle Corvette',
        'Rocket System Ship' => 'AEGIS Cruiser',
        'Missile Bay Ship' => 'Missile Destroyer',
        'Camo Missile Bay Ship' => 'Dazzle Missile Destroyer',
        'Stealth Missile Bay Ship' => 'Stealth Missile Corvette',
        'Wooden Deck Ship' => 'Escort Carrier',
        'Catapult Deck Ship' => 'Carrier',
        'Radar Deck Ship' => 'Super Carrier',

        'Multideck Trebuchet Heavy Ship' => 'Great Galleass',
        'Multideck Bombard Heavy Ship' => 'Galleon',
        'Multideck Cannon Heavy Ship' => 'Ship-of-the-Line',
        'Ironclad Cannon Heavy Ship' => 'Ironclad',
        'Multideck Artillery Heavy Ship' => 'Steam Battleship',
        'Ironclad Artillery Heavy Ship' => 'Pre-Dreadnought',
        'Armored Artillery Heavy Ship' => 'Dreadnought',
        'Ironclad Howitzer Heavy Ship' => 'Heavy Cruiser',
        'Armored Howitzer Heavy Ship' => 'Battlecruiser',
        'Heavy Armored Howitzer Heavy Ship' => 'Battleship',
        'Composite Armor Railgun Heavy Ship' => 'Railgun Cruiser',
        'Active Defense Railgun Heavy Ship' => 'Railgun Battlecruiser',

        'Torpedo Submarine' => 'Submarine',
        'Camouflaged Torpedo Submarine' => 'Dazzle Submarine',
        'HomingTorpedo Submarine' => 'Electric Submarine',
        'Camouflaged HomingTorpedo Submarine' => 'Dazzle Electric Submarine',

        'Air Machine Gun Fighter' => 'Biplane',
        'Sealing Tanks Air Machine Gun Fighter' => 'Fighter',
        'Air Homing Missile Fighter' => 'Jet Fighter',
        'Chaff Flare Air Homing Missile Fighter' => 'Supersonic Fighter',
        'Air Guided Missile Fighter' => 'Modern Fighter',
        'Stealth Air Guided Missile Fighter' => 'Stealth Fighter',
        'Air Ai Missile Fighter' => 'AI Jet Fighter',
        'Advanced Stealth Air Ai Missile Fighter' => 'AI Stealth Fighter',
    ];

    public function getStrengthAttribute(Unit $against = null): int
    {
        return $this->weapon?->strength($against) + $this->armor?->strength();
    }

    public static function namesAndCost(): Collection
    {
        $names = [];
        foreach (UnitType::cases() as $type) {
            foreach ($type->weapons() as $weapon) {
                foreach ($type->armors($weapon) as $armor) {
                    $unit = static::make([
                        'type' => $type,
                        'weapon' => $weapon,
                        'armor' => $armor,
                    ]);
                    $names[] = ['name' => $unit->name, 'cost' => $unit->cost, 'strength' => $unit->strength, 'ranged_strength' => $unit->ranged_strength];
                }
            }
        }
        return collect($names)->sortBy(fn($data) => $data['strength']);
    }
}
