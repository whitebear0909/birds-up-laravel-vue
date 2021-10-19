<template>
  <div class="d-flex flex-wrap">
    <div class="p-3 sidebar open">
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
    <div v-if="mapcovey != null" class="d-flex flex-grow-1 p-3 main-content">
        <div ref="map" id="mapView"></div>
    </div>   
    <b-spinner label="Spinning" v-else class="m-1"></b-spinner>
  </div>
</template>

<script>

import { loadModules } from 'esri-loader';
import { mapGetters } from 'vuex'

export default {
    data: () => ({
        appURL: window.config.appURL,
        pinsArr: {
            CP: "http://static.arcgis.com/images/Symbols/Basic/GreenStickpin.png",
            SP: "http://static.arcgis.com/images/Symbols/Basic/BlueStickpin.png",
            WF: "http://static.arcgis.com/images/Symbols/Basic/YellowStickpin.png",
            UP: "http://static.arcgis.com/images/Symbols/Basic/RedStickpin.png"
        },
        map: null,
        graphicsLayer: null,
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
        mapcovey: 'dashboard/mapcovey'
    }),
    mounted() {
        this.$store.dispatch('property/getAllProperties') 
        this.$store.dispatch('courses/getAllCourses')
        this.getMapCovey('')
    },
    methods: {
        getMapCovey(query) {
            this.$store.dispatch('dashboard/getMapCovey', query).then(() => {  
                this.loadMapLibrary();
            })
        },
        loadMapLibrary() {
            var self = this
            loadModules([
                "esri/Map",
                "esri/views/MapView",
                "esri/Graphic",
                "esri/layers/GraphicsLayer"], {

                    css: true
            })
            .then(([ArcGISMap, MapView, Graphic, GraphicsLayer]) => {
                
                if (self.map == null && self.graphicsLayer == null) {
                    // create map with the given options
                    self.map = new ArcGISMap({
                        basemap: 'topo-vector'
                    });
                    // assign map to this view
                    this.view = new MapView({
                        container: "mapView",
                        map: self.map,
                        center: [-118, 34],
                        zoom: 16
                    });

                    self.graphicsLayer = new GraphicsLayer(); 
                    
                    self.map.add(self.graphicsLayer);
                }

                self.graphicsLayer.removeAll()

                self.mapcovey.data.forEach(record => {

                    // Add a blue location pin
                    var pictureGraphic = new Graphic({
                        geometry: {
                            type: "point",
                            longitude: record.X_Coord,
                            latitude: record.Y_Coord
                        },
                        symbol: {
                            type: "picture-marker",
                            url: self.pinsArr[record.encType],
                            width: "26px",
                            height: "26px"
                        },
                        attributes: {
                            Name: record.encType,  // The name of the
                            Location: record.Comments,  // The owner of the
                        },
                        popupTemplate: {
                            title: "{Name}",
                            content: "<b>{Location}</b>."
                        }
                    });

                    self.graphicsLayer.add(pictureGraphic);

                    // Add text below the pin
                    var textGraphic = new Graphic({
                        geometry: {
                            type: "point",
                            longitude: record.X_Coord,
                            latitude: record.Y_Coord
                        },
                        symbol: {
                            type: "text",
                            color: [25,25,25],
                            haloColor: [255,255,255],
                            haloSize: "1px",
                            text: record.encType,
                            xoffset: 0,
                            yoffset: -25,
                            font: {
                                size: 12
                            }
                        }
                    });          
                    
                    self.graphicsLayer.add(textGraphic);
                    
                });

            });                  
        },

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
            // if (this.fromDate) {
            //     query += 'fromDate=' + this.fromDate + '&toDate=' + this.toDate
            // }

            this.getMapCovey(query)
        },
        
    }
}
</script>

<style lang="scss" scoped>

@import url('https://js.arcgis.com/4.18/esri/themes/light/main.css');

#mapView {
    padding: 0;
    margin: 0;
    height: 100%;
    width: 100%;
}

/* On screens that are 576px or less, set the background color to blue */
@media screen and (max-width: 576px) {

    #mapView {
        height: 400px;
    }
}

</style>
