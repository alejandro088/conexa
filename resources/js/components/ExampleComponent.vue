<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Earth</div>
                    <div id="movements">Movements: {{ movements }}</div>
                    <div id="positions">Final position: {{ positions }}</div>

                    <div class="card-body">
                        

                        <div v-for="(row, rowIndex) in grid" class="grid" :key="rowIndex">
                                <div v-for="(item, itemIndex) in row" class="grid-item" :key="itemIndex" :id="`item-${rowIndex}-${itemIndex}`">
                                    {{ rowIndex }},{{ itemIndex }} <span>{{ item }}</span>
                                </div>
                            </div>
                        <button @click="getMovements()">Get movements</button>

                        <button id="move" @click="move()">Move!!</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            movements: [],
            positions: [],
            grid: [
                [0, 0, 0],
                [0, 0, 0],
                [0, 0, 0]
            ],
            step: 0,
            timers: [],
        }
    },
    methods: {
        reset() {
            this.step = 0;
            this.positions = [];

            // clear all timeout
            this.timers.forEach(function(timer) {
                clearTimeout(timer);
            });


            this.grid = [
                [0, 0, 0],
                [0, 0, 0],
                [0, 0, 0]
            ];

            // reset background color in the grid

            for (let i = 0; i < 3; i++) {
                for (let j = 0; j < 3; j++) {
                    document.getElementById("item-" + i + "-" + j).style.backgroundColor = "white";
                    document.getElementById(`item-${i}-${j}`).innerHTML = `${i},${j} <span>${this.grid[i][j]}</span>`;
                }
            }

            
        },
        getMovements() {

            this.reset();

            document.getElementById("move").disabled = false;

            axios.get('/api/earth')
                .then(response => {
                    this.movements = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        move() {

            this.reset();

            //disable button
            document.getElementById("move").disabled = true;

            axios.post('/api/final-position',
                {
                    items: this.movements.map(movement => movement.substring(0, 1)),
                    initial: [0, 0]
                })
                .then(response => {
                    this.positions = response.data;
                    this.draw(this.positions);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        draw(positions) {

            console.log(positions);
            
            positions.movements.forEach((position, index) => {
                this.timers.push(setTimeout(() => {
                    console.log(this.step);
                    this.step++;
                    this.grid[position[0]][position[1]] = this.step;
                    document.getElementById(`item-${position[0]}-${position[1]}`).innerHTML = `${position[0]},${position[1]} <span>${this.step}</span>`;
                    // background-color with alpha blue in each step
                    document.getElementById(`item-${position[0]}-${position[1]}`).style.backgroundColor = `rgba(0, 0, 255, ${this.step / 10})`;
                    console.log(this.grid);

                }, 3000*index));
                      
            });
        }
    }
};
</script>

<style>
.grid {
    display: grid;
    grid-gap: 1px;
    grid-template-columns: repeat(3, 1fr);
}

.grid-item {
    background-color: #fff;
    height: 100px;
    width: 100px;
    margin: 10px;
}

span {
    display: table;
    margin: 0 auto;
}

div > div {
    padding: 10px;
    background-color: #ccc;
}
</style>
