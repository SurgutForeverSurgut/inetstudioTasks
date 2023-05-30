<?

abstract class SomeObject {
    protected $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    abstract function getObjectName(): string;
}

class MySomeObject extends SomeObject {

    public function getObjectName(): string {
        return $this->name;
    }

    public function handle(): string {
        return 'handle_' . $this->getObjectName();
    }
}

class SomeObjectsHandler {
    /**
     * @param SomeObject[]
     */
    public function handleObjects(array $objects): array {
        return array_map(function($item) {
            return $item->handle();
        }, $objects);
    }
}

$objects = [
    new MySomeObject('object_1'),
    new MySomeObject('object_2')
];

$soh = new SomeObjectsHandler();
$result = $soh->handleObjects($objects);