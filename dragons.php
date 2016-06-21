<?php


class Dragon
{

    public $name;
    public $power;

    public function __construct($name, $power)
    {
        $this->name = $name;
        $this->power = $power;
    }

    public function __toString()
    {
        return sprintf('%s is a %s dragon', $this->name, $this->power);
    }

    public function equals(Dragon $dragon)
    {
        return $dragon->getHash() === $this->getHash();
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'power' => $this->power
        ];
    }

    public function getHash()
    {
        return hash('md5', json_encode($this->toArray()));
    }
}

class DragonsComparator
{
    public static function uDiffDragons($myDragons, $hisDragons)
    {
        return array_udiff($myDragons, $hisDragons, function ($myDragon, $hisDragon) use ($myDragons) {
            if ($myDragon->equals($hisDragon)) {
                return 0;
            }
            return count(array_filter($myDragons, function($dragon) use ($hisDragon) {
                return $dragon->equals($hisDragon);
            })) == 0 ? 1 : -1;
        });
    }
}

$myDragons = [
    new Dragon('Bernard', 'fire'),
    new Dragon('Felix', 'ice'), // to return in diff
    new Dragon('Janush', 'fire'), // to return in diff
    new Dragon('Missy', 'gas')
];

$hisDragons = [
    new Dragon('Bernard', 'fire'),
    new Dragon('Flufy', 'ice'), // to return in diff
    new Dragon('Sleppy', 'none'), // to return in diff
    new Dragon('Missy', 'gas')
];


// get my unique dragons
$myDiff = DragonsComparator::uDiffDragons($myDragons, $hisDragons);

// get my unique dragons
$myDiff2 = DragonsComparator::uDiffDragons($myDragons, []);

// get his unique dragons
$hisDiff = DragonsComparator::uDiffDragons($hisDragons, $myDragons);


echo PHP_EOL;
echo json_encode($myDiff) . PHP_EOL;
echo json_encode($myDiff2) . PHP_EOL;
echo json_encode($hisDiff) . PHP_EOL;
