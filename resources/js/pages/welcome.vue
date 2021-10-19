<template>

  <div class="d-flex align-items-center app-welcome">
    <div class="app-description py-5 w-100">
      <div class="border-top border-bottom border-white app-description__content">
        <h1 class="main-title text-center py-5 animate__animated animate__fadeInDown animate__delay-1s">A Quail Hunting App</h1>
        <h3 class="sub-title text-center pb-5 font-italic animate__animated animate__fadeInDown">For the Truly Sophisticated Bird Hunter</h3>
      </div>
    </div>
  </div>
  
</template>

<script>
import { mapGetters } from 'vuex'

export default {

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>

<style lang="scss" scoped>

.app-description {
  background: rgba(255, 255, 255, 0.3);
  background-repeat: no-repeat;

  &__content {
    margin: 0 calc(100vw/8);
  }
}

.main-title, .sub-title {
  font-family: 'CalciteWebCoreIcons';
  font-weight: 600;
}

</style>
