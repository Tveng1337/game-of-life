<?php

class Life
{
    const DEAD = 0;

    const ALIVE = 1;

    const EMPTY = ' ';

    const CELL = '*';

    const CELLS_AROUND_COORDINATES = [
        [-1, -1], [-1, 0], [-1, 1],
        [0, -1],           [0, 1],
        [1, -1],  [1, 0],  [1, 1],
    ];

    /**
     * @var int
     */
    private int $height = 25;

    /**
     * @var int
     */
    private int $width = 25;

    /**
     * @var array
     */
    private array $life = [];

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    /**
     * @return array
     */
    public function getLife(): array
    {
        return $this->life;
    }

    /**
     * @param array $life
     */
    public function setLife(array $life): void
    {
        $this->life = $life;
    }

    /**
     * @param array|null $grid
     *
     * @return void
     */
    public function startGame(array $grid = null): void
    {
        is_array($grid) ? $this->setLife($grid) : $this->generateGrid();

        while (true) {
            system('clear');
            $this->render();
            $this->newGeneration();
            usleep(1000);
        }
    }

    /**
     * @return void
     */
    private function generateGrid(): void
    {
        for ($heightCounter = 0; $heightCounter < $this->height; $heightCounter++) {
            for ($widthCounter = 0; $widthCounter < $this->width; $widthCounter++) {
                $this->life[$heightCounter][$widthCounter] = rand(0, 1);
            }
        }
    }

    /**
     * @return void
     */
    private function newGeneration(): void
    {
        $newGrid = [];
        for ($heightCounter = 0; $heightCounter < $this->height; $heightCounter++) {
            for ($widthCounter = 0; $widthCounter < $this->width; $widthCounter++) {
                $counter = 0;
                $this->countCellsAround($counter, $heightCounter, $widthCounter);
                if ($this->life[$heightCounter][$widthCounter] === self::ALIVE) {
                    $newGrid[$heightCounter][$widthCounter] = $counter === 2 || $counter === 3 ? self::ALIVE : self::DEAD;
                } else {
                    if ($counter === 3) {
                        $newGrid[$heightCounter][$widthCounter] = self::ALIVE;
                    }
                }
            }
        }
        $this->life = $newGrid;
    }

    /**
     * @param int $counter
     * @param int $height
     * @param int $width
     *
     * @return void
     */
    private function countCellsAround(int &$counter, int $height, int $width): void
    {
        foreach (self::CELLS_AROUND_COORDINATES as $friendCoordinate) {
            if (isset($this->life[$height + $friendCoordinate[0]][$width + $friendCoordinate[1]])
                && $this->life[$height + $friendCoordinate[0]][$width + $friendCoordinate[1]] == self::ALIVE) {
                $counter++;
            }
        }
    }

    /**
     * @return void
     */
    private function render(): void
    {
        for ($heightCounter = 0; $heightCounter < $this->height; $heightCounter++) {
            for ($widthCounter = 0; $widthCounter < $this->width; $widthCounter++) {
                echo $this->life[$heightCounter][$widthCounter] ? self::CELL : self::EMPTY;
            }
            echo "\r\n";
        }
    }
}
$grid = new Life();
$testGrid = [
    [0, 1, 0],
    [0, 0, 1],
    [1, 1, 1],
];

$grid->startGame($testGrid);
//$grid->startGame();
