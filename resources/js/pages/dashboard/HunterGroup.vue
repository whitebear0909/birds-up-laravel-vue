<template>
  <div class="py-3 pl-3 pr-5">
    <h4 class="text-right">Hunter Group</h4>
    <div v-if="properties.length > 0">
      <div v-for="(property, index) in properties" :key="index">
        <h4 class="mb-3">{{property.propertyName}} – Hunter Group Names</h4>
        <div class="d-flex flex-wrap justify-content-start">
          <collection-item 
            :text="group.groupName" 
            :id="group.id" 
            v-for="group in huntergroups.filter(group => {return group.propertyName == property.propertyName})" 
            :key="group.id"
            @updateResource="updateGroup"
            @deleteResource="deleteGroup"></collection-item>
        </div>
        <input class="p-2 mb-5 w-100" @keyup.enter="createGroup" :property="property.propertyName" type="text" placeholder="Type in Group Name Here and Click Enter" />
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
    loadingTxt: "Loading Hunter Groups...."
  }),

  computed: mapGetters({
    properties: 'property/properties',
    huntergroups: 'huntergroup/huntergroups'
  }),

  mounted() {
    this.$store.dispatch('property/getAllProperties').then(() => {
      if (this.properties.length == 0) this.loadingTxt = "!Information - Please create Property to create new Hunter Group!"
    }); 
    this.$store.dispatch('huntergroup/getAllHuntergroups')
  },

  methods: {
    updateGroup(index, groupName) {
      this.$store.dispatch('huntergroup/updateHuntergroup', {index, groupName})
    },
    deleteGroup(index) {
      this.$store.dispatch('huntergroup/deleteHuntergroup', index)
    },
    createGroup(evt) {    
      if (evt.target.value.trim() == '') {
        // alert('Please input the Group Name.');
      }else {
        var payload = {
          propertyName: $(evt.target).attr('property'),
          groupName: evt.target.value
        }
        this.$store.dispatch('huntergroup/createHuntergroup', payload)
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
