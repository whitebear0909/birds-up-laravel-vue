<template>
  <div class="py-3 pl-3 pr-5">
    <h4 class="text-right">Hunt Courses</h4>
    <div v-if="properties.length > 0">
      <div v-for="(property, index) in properties" :key="index">
        <h4 class="mb-3">{{property.propertyName}} – Hunt Course Names</h4>
        <div class="d-flex flex-wrap justify-content-start">
          <collection-item 
            :text="course.courseName" 
            :id="course.id" 
            v-for="course in courses.filter(course => {return course.propertyName == property.propertyName})" 
            :key="course.id"
            @updateResource="updateCourse"
            @deleteResource="deleteCourse"></collection-item>
        </div>
        <input class="p-2 mb-5 w-100" @keyup.enter="createCourse" :property="property.propertyName" type="text" placeholder="Type in Course Name Here and Click Enter" />
      </div>
    </div>
    <h4 v-else>{{loadingTxt}}</h4>      
  </div>
</template>

<script>
import CollectionItem from '../../components/CollectionItem.vue'
import { mapGetters } from 'vuex'

export default {
  components: { CollectionItem },
  data: () => ({
    loadingTxt: "Loading Courses...."
  }),

  computed: mapGetters({
    properties: 'property/properties',
    courses: 'courses/courses'
  }),

  mounted() {
    this.$store.dispatch('property/getAllProperties').then(() => {
      if (this.properties.length == 0) this.loadingTxt = "!Information - Please create Property to create new Course!"
    }); 
    this.$store.dispatch('courses/getAllCourses').then(() => {
    }); 
  },

  methods: {
    updateCourse(index, courseName) {
      this.$store.dispatch('courses/updateCourse', {index, courseName})
    },
    deleteCourse(index) {
      this.$store.dispatch('courses/deleteCourse', index)
    },
    createCourse(evt) {    
      if (evt.target.value.trim() == '') {
        
      }else {
        var payload = {
          propertyName: $(evt.target).attr('property'),
          courseName: evt.target.value
        }
        this.$store.dispatch('courses/createCourse', payload)
        evt.target.value = ''
      }      
    }
  },
  
}
</script>

<style lang="scss" scoped>
input {
    outline: none;
    border: none;
    font-size: 25px;
}
</style>
