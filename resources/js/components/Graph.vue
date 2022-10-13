<template>
    <div class="pos-relative">
        <canvas ref="canvas"></canvas>

        <div>
            <button @click="updateGraph" class="btn btn-primary btn-xs mt-1 mh-10">Update</button>
            <label>
                <input type="checkbox" v-model="realtime">
            </label>
            <label>
                <input type="text" v-model="label">
            </label>
            <label>
                <input type="number" v-model="sale">
            </label>
            <button @click="sendData" class="btn btn-success btn-xs text mt-1 mh-100">Update</button>
        </div>
    </div>
</template>

<script>
    import { Line } from 'vue-chartjs'

    export default {
        extends: Line,
        data() {
            return {
                data: [],
                realtime: false,
                label: '',
                sale: 500
            }
        },
        mounted() {
            let socket = io('http://127.0.0.1:3000');
            socket.on('graph-action:App\\Events\\NewEvent', (data) => {
                this.data = data.message;
                this.sale = data.message.dataSets[0].data[4];
                this.label = data.message.labels[4];
                this.startChart(data.message);
            });
            this.updateGraph();
        },
        methods: {
            startChart(data) {
                this.renderChart(
                    {
                        labels: data.labels,
                        datasets: data.dataSets,
                    },
                    {
                        legend: {
                            display: true
                        },
                        tooltips: {
                            intersect: 0,
                        },
                        scales: {
                            yAxes: [
                                {
                                    gridLines: {
                                        color: "#1c1441",
                                        zeroLineColor: "#1c1441",
                                        lineWidth: 1,
                                        zeroLineWidth: 3
                                    },
                                    ticks: {
                                        fontColor: "#9f64d8",
                                        color: "black",
                                        padding: 10,
                                        beginAtZero: true
                                    }
                                }
                            ],
                            xAxes: [
                                {
                                    gridLines: {
                                        color: "#1c1441",
                                        lineWidth: 1,
                                        zeroLineColor: "#1c1441",
                                        zeroLineWidth: 3,
                                    },
                                    ticks: {
                                        fontColor: "#9f64d8",
                                        lineWidth: 1,
                                        padding: 10,
                                        beginAtZero: true
                                    }
                                }
                            ]
                        },
                        responsive: true,
                        maintainAspectRatio: true
                    }
                );
            },
            // getDataForGraph() {
            //     axios.get('/start/chart-data').then(res => {
            //         this.startChart(res.data);
            //         console.log(res);
            //     }).catch(rej => {
            //         console.log('catch');
            //         console.log(rej);
            //     });
            // },
            updateGraph() {
                axios.get('/start/chart-random').then(res => {
                    this.startChart(res.data);
                }).catch(rej => {
                    console.log('catch');
                    console.log(rej);
                });
            },
            sendData() {
                axios({
                    method: 'get',
                    url: '/start/socket-chart',
                    params: {
                        label: this.label,
                        realtime: this.realtime,
                        sale: this.sale,
                    }
                }).then(res => {
                    this.data = res.data
                }).catch(rej => {
                    console.log(rej);
                })
            }
        }
    }
</script>

<style scoped lang="scss">
    canvas {
        height: 300px;
        @media screen and (min-width: 991px){
            height: 300px;
        }
    }
    .pos-relative {
        position: relative;
        z-index: 1;
    }
</style>
