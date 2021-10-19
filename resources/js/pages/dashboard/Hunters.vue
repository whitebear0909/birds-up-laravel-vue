<template>
  <div class="py-3 pl-3 pr-5">
    <h4 class="text-right">Hunters</h4>
    <div v-if="huntergroups.length > 0">
      <div v-for="(group, index) in huntergroups" :key="index">        
        <h4 class="mb-3">{{group.groupName}} – Hunter Names</h4>
        <div class="d-flex flex-wrap justify-content-start mb-3">
          <collection-item 
            :text="hunter.hunterName" 
            :id="hunter.id" 
            v-for="hunter in hunters.filter(hunter => {return hunter.huntPartyName == group.groupName})" 
            :key="hunter.id"
            @updateResource="updateHunter"
            @deleteResource="deleteHunter"></collection-item>
        </div>
        <input class="p-2 mb-5 w-100" @keyup.enter="createHunter" :property="group.propertyName" :party="group.groupName" type="text" placeholder="Type in Hunter Name Here and Click Enter" />
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
    loadingTxt: "Loading Hunters...."
  }),
  
  computed: mapGetters({
    hunters: 'hunters/hunters',
    huntergroups: 'huntergroup/huntergroups'
  }),

  mounted() {
    this.$store.dispatch('huntergroup/getAllHuntergroups').then(() => {
      if (this.huntergroups.length == 0) this.loadingTxt = "!Information - Please create Hunter Group to create new Hunter!"
    }); 

    this.$store.dispatch('hunters/getAllHunters')
  },

  methods: {
    updateHunter(index, hunterName) {
      this.$store.dispatch('hunters/updateHunter', {index, hunterName})
    },
    deleteHunter(index) {
      this.$store.dispatch('hunters/deleteHunter', index)
    },
    createHunter(evt) {    
      if (evt.target.value.trim() == '') {
        // alert('Please input the Hunter Name.');
      }else {
        var payload = {
          propertyName: $(evt.target).attr('property'),
          hunterName: evt.target.value,
          huntPartyName: $(evt.target).attr('party')
        }
        this.$store.dispatch('hunters/createHunter', payload)
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
