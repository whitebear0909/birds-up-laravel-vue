<template>
    <canvas :id="id"></canvas>
</template>

<script>

export default {

    name: 'Chart',

    props: {
        data: {
            type: Array,
            default: []
        },
        labels: {
            type: Array,
            default: []
        },
        id: {
            type: String,
            default: ''
        }
    },

    data() {
        return {
            colors: ['#a9a57c','#9cbebd', '#d3cb6c'],
        }
    },

    mounted() {
        var chBar = document.getElementById(this.id);
        var datasets = []
        for (var i = 0; i < this.data.length; i++) {
            datasets.push({
                data: this.data[i],
                backgroundColor: this.colors[i]
            })
        }
        var chartData = {
            labels: this.labels,
            datasets: datasets
        };

        new Chart(chBar, {
          type: 'bar',
          data: chartData,
          options: {
            scales: {
              xAxes: [{
                barPercentage: 0.4,
                categoryPercentage: 0.5
              }],
              yAxes: [{
                ticks: {
                  beginAtZero: false
                }
              }]
            },
            legend: {
              display: false
            }
          }
        });
    }
}

</script>