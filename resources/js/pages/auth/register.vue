<template>
  <div class="app-welcome pt-5">
    <div class="col-lg-6 m-auto">
      <card :title="'Create Your User Login'">
        <form @submit.prevent="register" @keydown="form.onKeydown($event)">
          <!-- Username -->
          <div class="form-group row">
            <div class="col-md-12">
              <input 
                v-model="form.username" 
                :class="{ 'is-invalid': form.errors.has('username') }" 
                class="form-control" 
                type="text" 
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
                Create Login
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

export default {
  components: {

  },

  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('register') }
  },

  data: () => ({
    form: new Form({
      username: '',
      password: '',
      password_confirmation: ''
    }),
    remember: false
  }),

  mixins: [formMixin],

  methods: {
    async register () {
      const user = {
        username: this.form.username,
        password: this.form.password
      }
      const errors = this.validateForm(user);
      if (errors.formIsValid) {
        this.form.password_confirmation = this.form.password;
        const { data } = await this.form.post('/api/register');
        if (data.user) {
          // Log in the user.
          const { data: { access_token } } = await this.form.post('/api/login')
          // Save the token.
          this.$store.dispatch('auth/saveToken', { 
            token: access_token,
            remember: this.remember
          });

          // Update the user.
          await this.$store.dispatch('auth/updateUser', { user: data.user })

          // Redirect home.
          this.$router.push({ name: 'home.dashboard' })
        }
      }else {
        this.form.errors.errors = errors;
      }
    }
  }
}
</script>
