<template>
  <div class="d-flex flex-wrap">
    <b-nav vertical class="sidebar py-5 open">
      <!-- <b-nav-item>'s with child routes. Note the trailing slash on the first <b-nav-item> -->
      <b-nav-item to="/home/property" exact exact-active-class="active">
        <side-menu-item :title="'Property'" :url="appURL + 'assets/propertyIconImage.png'"></side-menu-item>
      </b-nav-item>
      <b-nav-item to="/home/courses" exact exact-active-class="active">
        <side-menu-item :title="'Courses'" :url="appURL + 'assets/courseIconImage.png'"></side-menu-item>
      </b-nav-item>
      <b-nav-item to="/home/huntergroup" exact exact-active-class="active">
        <side-menu-item :title="'Hunter Group'" :url="appURL + 'assets/huntersIconImage.png'"></side-menu-item>
      </b-nav-item>
      <b-nav-item to="/home/hunters" exact exact-active-class="active">
        <side-menu-item :title="'Hunters'" :url="appURL + 'assets/huntersIconImage.png'"></side-menu-item>
      </b-nav-item>
      <b-nav-item to="/home/dogs" exact exact-active-class="active">
        <side-menu-item :title="'Dogs'" :url="appURL + 'assets/dogsIconImage.png'"></side-menu-item>
      </b-nav-item>
    </b-nav>
    <div class="collapse-section d-flex align-items-center my-3">
      <a @click="sidebarHelper" class="mx-2 collapse-btn open" />
    </div>
    <div class="main-content flex-grow-1">
      <child />
    </div>       
    <modal name="delete-item-modal"
          :width="300"
          :height="'auto'"
          :adaptive="true"
          :clickToClose="false">

          <div class="modal-content">     
              <h4 class="modal-header">Alert</h4>  
              <div class="modal-body">
                  <p>Are you sure you want to delete this item?</p>
              </div>                     
              <div class="modal-footer justify-content-between">                                        
                  <b-button class="text-white" :variant="'custom1'" @click="sendDeleteDispatch">
                      Yes
                  </b-button>                    
                  <b-button class="text-white" :variant="'custom1'" @click="closeModal">
                      No
                  </b-button>
              </div>                 
          </div>
    </modal> 
  </div>
</template>

<script>
import SideMenuItem from '../components/SideMenuItem.vue'
export default {
  components: { SideMenuItem },
  middleware: 'auth',

  data: () => ({
    appURL: window.config.appURL,
    itemId: -1
  }),

  metaInfo () {
    return { title: this.$t('home') }
  },

  mounted() {
    this.$bus.on('OPEN_ITEM_DELETE_MODAL', (id) => {
      this.openModal(id)
    })
  },

  methods: {
    openModal(id) {
      this.itemId = id
      this.$modal.show('delete-item-modal')
    },
    closeModal() {
      this.$modal.hide('delete-item-modal')
    },
    sendDeleteDispatch() {
      this.closeModal()
      this.$bus.emit('ITEM_DELETE_EVENT', this.itemId)
    }
  }
}
</script>

<style lang="scss" scoped>
.nav-link {
  &.active {
    & > .menu-container {
      border-color: #ff5e00 !important;
    }
  }
}
</style>
