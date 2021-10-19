<template>
  <div class="app-welcome pt-5">
    <div class="col-lg-6 m-auto">
      <card :title="'Login'">
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
          <!-- Email -->
          <div class="form-group row">
            <div class="col-md-12">
              <input 
                v-model="form.username" 
                :class="{ 'is-invalid': form.errors.has('username') }" 
                class="form-control" 
                type="username" 
                name="username"
                placeholder="Username">
              <has-error :form="form" field="username" />
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
            <div class="col-md-12">
              <input 
                v-model="form.password" 
                :class="{ 'is-invalid': form.errors.has('password') }" 
                class="form-control" 
                type="password" 
                name="password"
                placeholder="Password">
              <has-error :form="form" field="password" />
            </div>
          </div>

          <!-- Remember Me -->
          <div class="form-group row">
            <div class="col-md-12 d-flex">
              <checkbox v-model="remember" name="remember">
                {{ $t('remember_me') }}
              </checkbox>

              <v-button class="ml-auto text-white" :type="'custom1'" :loading="form.busy">
                {{ $t('login') }}
              </v-button>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import formMixin from '../../mixins/formMixin';
import Cookies from 'js-cookie'

export default {
  components: {

  },

  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('login') }
  },

  mixins: [formMixin],

  data: () => ({
    form: new Form({
      username: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
    async login () {

      const user = {
        username: this.form.username,
        password: this.form.password
      }
      const errors = this.validateForm(user);
      if (errors.formIsValid) {

        // Submit the form.
        const { data: { access_token, user } } = await this.form.post('/api/login')

        // Save the token.
        this.$store.dispatch('auth/saveToken', {
          token: access_token,
          remember: this.remember
        })

        // Update the user.
        await this.$store.dispatch('auth/updateUser', { user: user })

        // Redirect home.
        this.redirect()
      }else {
        this.form.errors.errors = errors;
      }
    },

    redirect () {
      const intendedUrl = Cookies.get('intended_url')

      if (intendedUrl) {
        Cookies.remove('intended_url')
        this.$router.push({ path: intendedUrl })
      } else {
        this.$router.push({ name: 'home.dashboard' })
      }
    }
  }
}
</script>
