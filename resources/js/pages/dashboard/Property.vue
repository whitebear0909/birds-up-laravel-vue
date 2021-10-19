<template>
  <div class="py-3 pl-3 pr-5">
      <h4 class="text-right mb-3">Property Names</h4>
      <div class="d-flex flex-wrap justify-content-start mb-3" v-if="properties.length > 0">
        <collection-item 
          :text="property.propertyName" 
          :id="index" 
          v-for="(property, index) in properties" 
          :key="property.id"
          @updateResource="updateProperty"
          @deleteResource="deleteProperty"></collection-item>
      </div>
      <input class="p-2 w-100" v-model="propertyName" type="text" @keyup.enter="createProperty" placeholder="Type in Property Name Here and Click Enter" />
  </div>
</template>

<script>
import CollectionItem from '../../components/CollectionItem.vue'
import { mapGetters } from 'vuex'

export default {
  components: { CollectionItem },
  data: () => ({
    propertyName: ''
  }),

  computed: mapGetters({
    properties: 'property/properties'
  }),

  mounted() {
    this.$store.dispatch('property/getAllProperties') 
  },

  methods: {
    updateProperty(index, propertyName) {
      this.$store.dispatch('property/updateProperty', {index, propertyName})
    },
    deleteProperty(index) {
      this.$store.dispatch('property/deleteProperty', index)
    },
    createProperty() {      
      if (this.propertyName.trim() == '') {
        // alert('Please input the Property Name.');
      }else {
        var payload = {
          propertyName: this.propertyName
        }
        this.$store.dispatch('property/createProperty', payload)
        this.propertyName = ''
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