<template>
  <div class="menu-container mx-auto border border-dark">
      <div class="menu-image mx-auto">
          <img class="mx-auto" :src="url" />
      </div>      
      <p class="text-center text-dark"> {{ title }} </p>
  </div>
</template>

<script>
export default {
  name: 'SideMenuItem',

  props: {
    title: {
      type: String,
      default: 'Property'
    },
    url: {
        type: String,
        default: 'assets/propertyIconImage.png'
    }
  }
}
</script>

<style scoped lang="scss">
img, .menu-image {
  width: 80px;
}
.menu-container {
    width: 120px;
    height: 120px;
    border-radius: 10px;
    transition: 0.5s;
    border-width: 2px !important;

    &:hover {
      border-color: #ff5e00 !important;
    }
}
</style>
