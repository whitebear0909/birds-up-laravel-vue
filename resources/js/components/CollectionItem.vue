<template>
  <div class="border border-dark px-2 mb-2 mr-2">
    <input 
        :id="'collection-text' + id" 
        class="p-2 text-center" 
        type="text"                 
        v-model="updatedTxt"
        readonly />
    <a @click="handleAction(0)"><font-awesome-icon :icon="editing? 'save' : 'edit'" /></a>
    <a @click="handleAction(1)"><font-awesome-icon icon="trash-alt" /></a>      
  </div>
</template>

<script>

export default {
  name: 'CollectionItem',
  props: {
      text: {
          type: String,
          default: ""
      },
      id: {
          type: Number,
          default: 0
      }
  },
  data() {
      return {
        editing: false,
        updatedTxt: this.text
      }    
  },
  mounted() {
    this.$bus.on('ITEM_DELETE_EVENT', (id) => {
        this.sendDeleteDispatch(id)
    })
  },
  methods: {
    handleAction(val) {
          if (val == 0) {
            this.editing = !this.editing;
            if (this.editing) {
                $("#collection-text" + this.id).attr("readonly", false); 
                $("#collection-text" + this.id).focus();                
            }else {
                $("#collection-text" + this.id).attr("readonly", true); 
                this.$emit('updateResource', this.id, this.updatedTxt);
            }            
          }else {
              this.$bus.emit('OPEN_ITEM_DELETE_MODAL', this.id)
          }
    },
    sendDeleteDispatch(id) {
        if (this.id == id) {
            this.$emit('deleteResource', this.id)
        }        
    }      
  }
}
</script>

<style lang="scss" scoped>
input {
    outline: none;
    border: none;
    width: 170px;
}
.border {
    border-radius: 5px;
}
a {
    cursor: pointer;
}
</style>
