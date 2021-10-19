<template>
  <div class="d-flex flex-wrap">
    <div class="sidebar open p-3">
        <form class="form">
            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Hunt Type</label>
            <select v-model="selectedHuntType" @change="handleSearch" class="custom-select my-1 mr-sm-2" >
                <option value="Horseback">Horseback</option>
                <option value="Walk">Walk</option>
                <option value="Training Other">Training Other</option>
            </select>
        </form>
        <form class="form">
            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Property</label>
            <select v-model="selectedProperty" @change="handleSearch" class="custom-select my-1 mr-sm-2" v-if="properties.length > 0">
                <option v-for="property in properties" :key="property.id" :value="property.propertyName"> {{ property.propertyName }} </option>                
            </select>
            <select class="custom-select my-1 mr-sm-2" v-else>
                <option selected>Choose...</option>
            </select>
        </form>
        <form class="form">
            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Course</label>
            <select v-model="selectedCourse" @change="handleSearch" class="custom-select my-1 mr-sm-2" v-if="courses.length > 0">
                <option v-for="course in courses" :key="course.id" :value="course.courseName"> {{ course.courseName }} </option>                
            </select>
            <select class="custom-select my-1 mr-sm-2" v-else>
                <option selected>Choose...</option>
            </select>
        </form>
        <form class="form">
            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Enc Type</label>
            <select v-model="selectedEncType" @change="handleSearch" class="custom-select my-1 mr-sm-2" >
                <option value="CP">Covey Point</option>
                <option value="SP">Single Point</option>
                <option value="WF">Wild Flush</option>
                <option value="UP">Unproductive Point</option>
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
    <div class="d-flex flex-grow-1 main-content p-3 flex-wrap">
      <div class="col-md-9 col-sm-12 col-12">
          <div class="d-flex align-items-center justify-content-between p-3 mb-3 border border-dark course-header">
            <div>
                <h5 class="text-center">Display View</h5>
                <ul class="nav nav-tabs justify-content-center">
                  <li class="mr-2">
                    <a data-toggle="tab" class="tab-btn active" href="#chartView">
                      <img :src="appURL + 'assets/figureIconImage.png'" />
                    </a>
                  </li>
                  <li class="">
                    <a data-toggle="tab" class="tab-btn" href="#tableView">
                      <img :src="appURL + 'assets/tableIconImage.png'" />
                    </a>
                  </li>
                </ul>
            </div>
            <h3 class="text-center">{{ properties.length > 0  && selectedProperty ? selectedProperty : 'Overall' }} Plantation</h3>
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
          <div class="d-flex justify-content-end align-items-center">
            <div class="mr-1" style="width:20px;height:20px;background-color:#a9a57c;"></div>
            <div class="mr-2 font-weight-bold">CMH</div>
            <div class="mr-1" style="width:20px;height:20px;background-color:#9cbebd"></div>
            <div class="mr-2 font-weight-bold">CPH</div>
            <div class="mr-1" style="width:20px;height:20px;background-color:#d3cb6c"></div>
            <div class="font-weight-bold">CSH</div>
          </div>
          <div class="tab-content clearfix mt-3">
			          <div class="tab-pane fade in active show" id="chartView">
                    <div class="card-body">
                        <chart :id="'courseMetricsChart'" :data="chartValues" :labels="labels" v-if="labels.length > 0"></chart>
                    </div>
                </div>
                <div class="tab-pane fade table-responsive" id="tableView">
                    <table class="table" v-if="coursemetrics && coursemetrics.tblData.length > 0" id="printTable">
                        <thead class="thead-dark">
                            <tr>                              
                              <th scope="col" v-for="(item, index) in Object.keys(coursemetrics.tblData[0])" :key="index">{{ item }}</th>                              
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data, index) in coursemetrics.tblData" :key="index">
                              <td class="text-center" v-for="(item, ind) in Object.values(data)" :key="ind">{{ item }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
		      </div>
      </div>
      <div class="col-md-3 col-sm-12 col-12 px-3">
        <div class="d-flex align-items-center info-item column flex-column mb-3">
            <h1 class="py-3 text-center">{{ this.topCourse }}</h1>
            <h5 class="text-white text-center">Top Courses</h5>
        </div>
        <div class="d-flex align-items-center info-item column flex-column mb-3">
            <h1 class="py-3 text-center"> {{ this.coursemetrics && this.coursemetrics.boxData.CPs ? parseFloat(this.coursemetrics.boxData.CPs) + parseFloat(this.coursemetrics.boxData.WFs) : 0 }}</h1>
            <h5 class="text-white text-center">Coveys Seen</h5>
        </div>
        <div class="d-flex align-items-center info-item column flex-column mb-3">
            <h1 class="py-3 text-center">{{ this.coursemetrics && this.coursemetrics.boxData.BH ? this.coursemetrics.boxData.BH : 0 }}</h1>
            <h5 class="text-white text-center">Birds Harvested</h5>
        </div>
      </div>
    </div>   
  </div>
</template>

<script>
import axios from 'axios';
import html2canvas from 'html2canvas';
import DateRangePicker from "../components/DateRangePicker.vue";
import { mapGetters } from 'vuex'

export default {
  components: { 
    DateRangePicker 
  },
  data: () => ({
    appURL: window.config.appURL,
    labels: [],
    chartValues: [],
    topCourse: '',
    convertFlag: false,
    selectedProperty: '',
    selectedHuntType: '',
    selectedCourse: '',
    selectedEncType: '',
    fromDate: '',
    toDate: '' 
  }),

  computed: mapGetters({
    courses: 'courses/courses',
    properties: 'property/properties',
    coursemetrics: 'courses/coursemetrics'
  }),

  methods: {
    setDateRange(start, end) {
      this.fromDate = start
      this.toDate = end
      this.handleSearch()
    },
    handleSearch() {
      var query = '?'
      if (this.selectedProperty) {
        query += 'property=' + this.selectedProperty + '&'
      }
      if (this.selectedHuntType) {
        query += 'huntType=' + this.selectedHuntType + '&'
      }
      if (this.selectedCourse) {
        query += 'course=' + this.selectedCourse + '&'
      }
      if (this.selectedEncType) {
        query += 'encType=' + this.selectedEncType + '&'
      }
      if (this.fromDate) {
        query += 'fromDate=' + this.fromDate + '&toDate=' + this.toDate
      }

      this.getCourseMetrics(query)
    },
    getCourseMetrics(query) {
      this.$store.dispatch('courses/getCourseMetrics', query).then(() => {  
        var array_CMH = []
        var array_CPH = []
        var array_CSH = []    
        var labels = []
        var topCourseValue = 0;
        var topCourse = '';
        this.coursemetrics.chartData.forEach(function(data) {
          labels.push(data.huntCourse)
          array_CMH.push(data.CMH)
          array_CPH.push(data.CPH)
          array_CSH.push(data.CSH)
          if (topCourseValue < Math.max(parseFloat(data.CMH), parseFloat(data.CPH), parseFloat(data.CSH))) {
            topCourse = data.huntCourse
            topCourseValue = Math.max(parseFloat(data.CMH), parseFloat(data.CPH), parseFloat(data.CSH))
          }
        });
        this.topCourse = topCourse;
        this.chartValues = [array_CMH, array_CPH, array_CSH]
        this.labels = labels
      });
    },
    exportCsv(){
      axios.post('/api/csv')
        .then(res => {
        }).catch(err => {
        console.log(err)
      })
    },
    async exportPdf(){
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
        width : (input.scrollWidth + 20),
        windowWidth: input.scrollWidth, 
        windowHeight: input.scrollHeight, 
        x: 250, 
        scrollX: (input.parentNode.scrollLeft*0.84), 
        scale: 1
      }).then(canvas => {
          const link = document.createElement('a');
          link.href= canvas.toDataURL();
          link.setAttribute('download', 'course-metrics.png');
          document.body.appendChild(link);
          link.click();
      });
    }
  },

  mounted () {    
    this.$store.dispatch('property/getAllProperties') 
    this.$store.dispatch('courses/getAllCourses')
    this.getCourseMetrics('')
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

.tab-btn {
  & > img {
    border: none;
  }
  &.active > img {
    border: 1px solid #ff5e00;
  }
}

.nav-tabs {
  border: none !important;
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