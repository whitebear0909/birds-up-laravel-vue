<template>
  <div class="py-4 px-3">
      <h2 class="dashboard-heading text-center">2020|2021 Hunting Season Overview</h2>
      <div class="d-flex justify-content-end align-items-center mb-4">
        <div class="mr-1" style="width:20px;height:20px;background-color:#a9a57c;"></div>
        <div class="mr-2 font-weight-bold">CMH</div>
        <div class="mr-1" style="width:20px;height:20px;background-color:#9cbebd"></div>
        <div class="mr-2 font-weight-bold">CPH</div>
        <div class="mr-1" style="width:20px;height:20px;background-color:#d3cb6c"></div>
        <div class="font-weight-bold">CSH</div>
      </div>
      <div class="dashboard-content">
        <div class="chart-section d-flex flex-wrap col-md-12 mb-4">
          <div class="col-md-6 col-12">
            <chart :id="'userChart'" :data="chartValues" :labels="labels" v-if="labels.length > 0"></chart>
          </div>
          <div class="col-md-6 col-12">
            <chart :id="'allPropChart'" :data="[[dashboard.allPropChart.CMH], [dashboard.allPropChart.CPH], [dashboard.allPropChart.CSH]]" :labels="['All Properties Combined']" v-if="labels.length > 0"></chart>
          </div>          
        </div>        
        <div class="d-flex justify-content-between info-section flex-wrap">
          <div class="d-flex align-items-center info-item flex-column col-md-2 col-sm-5 col-12 mb-2">
            <h1 class="py-3 box-header"> {{ this.dashboard && this.dashboard.firstBox.Hunts ? this.dashboard.firstBox.Hunts : 0 }} </h1>
            <h5 class="text-white text-center">Hunts</h5>
          </div>
          <div class="d-flex align-items-center info-item flex-column col-md-2 col-sm-5 col-12 mb-2">
            <h1 class="py-3 box-header"> {{ this.dashboard && this.dashboard.firstBox.BH ? this.dashboard.firstBox.BH : 0 }} </h1>
            <h5 class="text-white text-center">Birds Harvested</h5>
          </div>
          <div class="d-flex align-items-center info-item flex-column col-md-2 col-sm-5 col-12 mb-2">
            <h1 class="py-3 box-header"> {{ this.dashboard && this.dashboard.secondBox.CP ? parseInt(this.dashboard.secondBox.CP) : 0 }} </h1>
            <h5 class="text-white text-center">Coveys Pointed</h5>
          </div>
          <div class="d-flex align-items-center info-item flex-column col-md-2 col-sm-5 col-12 mb-2">
            <h1 class="py-3 box-header"> {{ this.dashboard && this.dashboard.secondBox.CS ? parseInt(this.dashboard.secondBox.CS) : 0 }} </h1>
            <h5 class="text-white text-center">Coveys Shot</h5>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Chart from "../../components/Chart.vue"

export default {
  components: { Chart }, 

  data: () => ({
    labels: [],
    chartValues: []
  }),

  computed: mapGetters({
    dashboard: 'dashboard/dashboard'
  }),

  mounted () {
    this.$store.dispatch('dashboard/getDashboard').then(() => {  
      var array_CMH = []
      var array_CPH = []
      var array_CSH = []    
      var labels = []
      this.dashboard.chartData.forEach(function(data) {
        labels.push(data.propertyName)
        array_CMH.push(data.CMH)
        array_CPH.push(data.CPH)
        array_CSH.push(data.CSH)
      });
      this.chartValues = [array_CMH, array_CPH, array_CSH]
      this.labels = labels
    });
  },
}

</script>

<style lang="scss" scoped>

.card {
  width: 45%;
}

.box-header {
  font-size: 70px;
}

@media screen and (min-width: 768px) {
   .col-md-2 {
      max-width: 20% !important;
      flex: 0 0 20%;
    } 
}  

</style>