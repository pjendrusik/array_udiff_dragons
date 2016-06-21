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
        if ($dragon->name === $this->name && $dragon->power === $this->power) {
            return true;
        }
        return false;
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
$myDiff = array_udiff($myDragons, $hisDragons, function ($myDragon, $hisDragon) use ($myDragons) {
    if ($myDragon->equals($hisDragon)) {
        return 0;
    }
    return count(array_filter($myDragons, function($dragon) use ($hisDragon) {
        return $dragon->equals($hisDragon);
    })) == 0 ? 1 : -1;
});

// get my unique dragons
$myDiff2 = array_udiff($myDragons, [], function ($myDragon, $hisDragon) use ($myDragons) {
    if ($myDragon->equals($hisDragon)) {
        return 0;
    }
    return count(array_filter($myDragons, function($dragon) use ($hisDragon) {
        return $dragon->equals($hisDragon);
    })) == 0 ? 1 : -1;
});

// get his unique dragons
$hisDiff = array_udiff($hisDragons, $myDragons, function ($myDragon, $hisDragon) use ($hisDragons){
    if ($myDragon->equals($hisDragon)) {
        return 0;
    }
    return count(array_filter($hisDragons, function($dragon) use ($hisDragon) {
        return $dragon->equals($hisDragon);
    })) == 0 ? 1 : -1;
});

echo PHP_EOL;
echo json_encode($myDiff) . PHP_EOL;
echo json_encode($myDiff2) . PHP_EOL;
echo json_encode($hisDiff) . PHP_EOL;
