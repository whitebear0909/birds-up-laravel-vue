<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <div class="container" v-if="user == null">
      <router-link :to="{ name: 'welcome' }" class="navbar-brand font-weight-normal text-white">
        <img class="app-logo" :src="appURL + 'assets/BirdsUpLogo_Transparent.png'" />
        {{ appName }}
      </router-link>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
        <span class="navbar-toggler-icon" />
      </button>

      <div id="navbarToggler" class="collapse navbar-collapse">
        <ul class="navbar-nav align-items-center">
          <!-- <li class="nav-item">
            <router-link :to="{ name: 'welcome' }" class="nav-link text-inactive" active-class="active">
              Home
            </router-link>
          </li> -->
          <li class="nav-item">
            <router-link :to="{ name: 'about' }" class="nav-link text-inactive font-weight-normal" active-class="active">
              About
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'contact-us' }" class="nav-link text-inactive font-weight-normal" active-class="active">
              Contact Us
            </router-link>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto align-items-center">          
          <li class="nav-item">
            <router-link :to="{ name: 'login' }" class="nav-link text-inactive font-weight-normal" active-class="active">
              Login
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'register' }" class="nav-link text-inactive font-weight-normal" active-class="active">
              Sign Up
            </router-link>
          </li>
        </ul>
      </div>
    </div>
    <div class="container" v-else>
      
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
        <span class="navbar-toggler-icon" />
      </button>

      <div id="navbarToggler" class="collapse navbar-collapse">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item pr-3 border-right">
            <router-link :to="{ name: 'home.dashboard' }" class="nav-link text-inactive font-weight-normal" active-class="active">
              Dashboard
            </router-link>
          </li>
          <li class="nav-item pl-3">
            <router-link :to="{ name: 'course-metrics' }" class="nav-link text-inactive text-center font-weight-normal" active-class="active">
              Course <br> Metrics
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'dog-performance' }" class="nav-link text-inactive text-center font-weight-normal" active-class="active">
              Dog <br> Performance
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'map-covey' }" class="nav-link text-inactive text-center font-weight-normal" active-class="active">
              Map Covey <br> Encounters
            </router-link>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto align-items-center">
          <li class="nav-item">
            <router-link :to="{ name: 'contact-us' }" class="nav-link text-inactive font-weight-normal" active-class="active">
              Contact Us
            </router-link>
          </li>          
          <li class="nav-item">
            <a @click="logout" class="nav-link text-inactive logout font-weight-normal" active-class="active">
              Log Out
            </a>
          </li>
        </ul>
      </div>

      <router-link :to="{ name: 'welcome' }" class="navbar-brand text-white font-weight-normal">
        <img class="app-logo" :src="appURL + 'assets/BirdsUpLogo_Transparent.png'" />
        {{ appName }}
      </router-link>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  components: {
  },

  data: () => ({
    appName: window.config.appName,
    appURL: window.config.appURL
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style lang="scss" scoped>
.app-logo {
  width: 70px;
  height: 70px;
}

.logout {
  cursor: pointer;
}

.navbar-brand {
  font-family: 'CalciteWebCoreIcons';
  font-size: 35px;
}

.nav-link {
  font-size: 20px;
}
</style>
