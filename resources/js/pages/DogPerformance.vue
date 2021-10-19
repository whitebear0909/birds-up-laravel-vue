<template>
  <div class="d-flex flex-wrap">
    <div class="sidebar open p-3">
        <form class="form">
            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select Dog</label>
            <select v-model="selectedDog" class="custom-select my-1 mr-sm-2" v-if="dogs.length > 0">
                <option v-for="(dog, index) in dogs" :key="dog.id" :value="index" :selected="index == 0? true : false"> {{ dog.dogName }} </option>                
            </select>
            <select class="custom-select my-1 mr-sm-2" v-else>
                <option selected>Choose...</option>
            </select>
        </form>
        <form class="form">
            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Hunt Type</label>
            <select class="custom-select my-1 mr-sm-2">
                <option value="0" selected>Horseback</option>
                <option value="1">Walk</option>
                <option value="2">Training Other</option>
            </select>
        </form>
        <form class="form">
            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Property</label>
            <select class="custom-select my-1 mr-sm-2" v-if="properties.length > 0">
                <option v-for="(property, index) in properties" :key="property.id" :value="property.id" :selected="index == 0? true : false"> {{ property.propertyName }} </option>                
            </select>
            <select class="custom-select my-1 mr-sm-2" v-else>
                <option selected>Choose...</option>
            </select>
        </form>     
        <form class="form">
            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Date Range</label>
            <date-range-picker @rangeUpdate="setDateRange"></date-range-picker>
        </form>
    </div>
    <div class="collapse-section d-flex align-items-center my-3">
      <a @click="sidebarHelper" class="mx-2 collapse-btn open" />
    </div>
    <div class="d-flex flex-grow-1 p-3 main-content flex-wrap">
      <div class="col-md-9 col-sm-12 col-12">
          <div class="d-flex align-items-center justify-content-between p-3 border border-dark course-header">
                <h3>{{ dogs.length > 0 ? dogs[selectedDog].dogName : '' }}'s Hunt Performance</h3>
                <div>
                    <h5 class="text-center">Export Data</h5>
                    <div class="d-flex justify-content-center">
                      <a :href="appURL + 'api/csv'">
                          <img :src="appURL + 'assets/exportCSVIconImage.png'"/>
                      </a>
                      <a @click="exportPdf">
                          <b-spinner label="Spinning" v-if="convertFlag" class="m-1"></b-spinner>
                          <img :src="appURL + 'assets/exportPDFIconImage.png'" v-else />
                      </a>
                      <a @click="exportImg">
                          <img :src="appURL + 'assets/jpgIconImage.png'" />
                      </a>
                    </div>
                </div>
            </div>          
            <h5 class="pt-3">{{ dogs.length > 0 ? dogs[selectedDog].dogName : '' }}'s Summary Hunt Statistics</h5>	
            <div class="table-responsive">
              <table class="table">
                  <thead class="thead-dark">
                      <tr>
                        <th scope="col"></th>
                        <th scope="col">Total</th>
                        <th scope="col">Rank</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                        <th scope="row">Number Hunts</th>
                        <td>12</td>
                        <td>1 of 32</td>
                      </tr>
                      <tr>
                        <th scope="row">Ground Time</th>
                        <td>12:36</td>
                        <td>1 of 32</td>
                      </tr>
                      <tr>
                        <th scope="row">Coveys Pointed</th>
                        <td>31</td>
                        <td>1 of 32</td>
                      </tr>
                      <tr>
                        <th scope="row">Single Points</th>
                        <td>3</td>
                        <td>30 of 32</td>
                      </tr>
                      <tr>
                        <th scope="row">Wild Flushes</th>
                        <td>2</td>
                        <td>22 of 32</td>
                      </tr>
                      <tr>
                        <th scope="row">Unproductive Points</th>
                        <td>1</td>
                        <td>2 of 32</td>
                      </tr>
                      <tr>
                        <th scope="row">CMH</th>
                        <td>2.94</td>
                        <td>2 of 32</td>
                      </tr>
                      <tr>
                        <th scope="row">CPH</th>
                        <td>2.46</td>
                        <td>2 of 32</td>
                      </tr>
                  </tbody>
              </table>
            </div>
            <div class="table-responsive">
              <table id="printTable" class="table table-bordered" v-if="dogperformance && dogperformance.tblData.length > 0">
                  <thead class="thead-dark">
                      <tr>                              
                        <th scope="col" v-for="(item, index) in Object.keys(dogperformance.tblData[0])" :key="index">{{ item }}</th>                              
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="(data, index) in dogperformance.tblData" :key="index">
                        <td v-for="(item, ind) in Object.values(data)" :key="ind">{{ item }}</td>
                      </tr>
                  </tbody>
              </table>
            </div>            
      </div>
      <div class="col-md-3 col-sm-12 col-12 px-3">
        <div class="d-flex align-items-center info-item column flex-column mb-3">
            <h1 class="py-3 text-center">2</h1>
            <h5 class="text-white text-center">Overall Rank</h5>
        </div>
        <div class="d-flex align-items-center info-item column flex-column mb-3">
            <h1 class="py-3 text-center"> 367</h1>
            <h5 class="text-white text-center">Coveys Encounters</h5>
        </div>
        <div class="d-flex align-items-center info-item column flex-column mb-3">
            <h1 class="py-3 text-center">80</h1>
            <h5 class="text-white text-center">% Pointed</h5>
        </div>
      </div>
    </div>   
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios';
import html2canvas from 'html2canvas';

export default {
  data: () => ({
    appURL: window.config.appURL,
    convertFlag: false,
    selectedDog: 0,
  }),

  computed: mapGetters({
    dogs: 'dogs/dogs',
    properties: 'property/properties',
    dogperformance: 'dogs/dogperformance'
  }),

  mounted() {
    this.$store.dispatch('property/getAllProperties') 
    this.$store.dispatch('dogs/getAllDogs')
    this.$store.dispatch('dogs/getDogPerformance').then(() => {  
      
    });
  },

  methods: {
    setDateRange(start, end) {
      // alert(start);
    },
    exportCsv(){
      axios.post('/api/csv')
        .then(res => {
        }).catch(err => {
        console.log(err)
      })
    },
    exportPdf(){
      var self = this;
      if (!self.convertFlag) {        
        self.convertFlag = true;
        axios({
          url: '/api/pdf',
          method: 'GET',
          responseType: 'blob',
        }).then((response) => {
          self.convertFlag = false;

          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', 'file.pdf');
          document.body.appendChild(link);
          link.click();
        });
      }
    },
    exportImg(){
      const input = document.getElementById('printTable');
      window.scrollTo(0,0);
      html2canvas(input,{ 
        width : (input.scrollWidth + 50),
        // windowWidth: input.scrollWidth, 
        x: 240,
        scale: 0.9
      }).then(canvas => {
        console.log(canvas);
          const link = document.createElement('a');
          link.href= canvas.toDataURL();
          link.setAttribute('download', 'course-metrics.png');
          document.body.appendChild(link);
          link.click();
      });
    }
  },
}
</script>

<style lang="scss" scoped>
img {
    width: 3vw;
}

h5 {
  font-size: 1.5vw;
}

h3 {
  font-size: 2.5vw;
}

h1 {
  font-size: 3vw;
}

a {
  cursor: pointer;
}

/* On screens that are 576px or less, set the background color to blue */
@media screen and (max-width: 576px) {

  img {
      width: 5vw;
  }

  h5 {
    font-size: 2.5vw;
  }

  h3 {
    font-size: 3.5vw;
  }

  h1 {
    font-size: 4vw;
  }
}
</style>