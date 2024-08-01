<template>
  <div class="login-page fundo">
    <div class="container">
      <div class="row h-100 align-items-center justify-content-center">
        <div class="login-box" id="app">
          <div class="login-logo col-12">
            <img :src="logoSrc" alt="Logo">
          </div>
          <!-- /.login-logo -->
          <div class="login-box-body col-12" style="border-radius:0.25rem">
            <div class="row">
              <h4 class="text-center col-12">Painel Administrativo</h4>
              <br><br>
              <form @submit.prevent="login" class="form-horizontal col-12">
                <div class="form-group has-feedback" :class="{ 'form-group has-warning': errors.email }">
                  <input v-model="email" type="email" class="form-control" placeholder="Usuário" required autofocus>
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  <span v-if="errors.email" class="help-block">
                    <strong>{{ errors.email }}</strong>
                  </span>
                </div>
                <div class="form-group has-feedback" :class="{ 'form-group has-warning': errors.password }">
                  <input v-model="password" type="password" class="form-control" placeholder="Senha" required>
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  <span v-if="errors.password" class="help-block">
                    <strong>{{ errors.password }}</strong>
                  </span>
                </div>
                <div class="row align-items-center">
                  <div class="col-8">
                    <div class="row align-items-center">
                      <label class="col-12 d-flex align-items-center">
                        <input type="checkbox" v-model="remember"> Lembrar-me
                      </label>
                    </div>
                  </div>
                  <div class="col-4">
                    <button type="submit" class="btn btn-success btn-block btn-flat" style="border-radius:0.25rem">
                      Acessar
                    </button>
                  </div>
                </div>
              </form>
            </div>
            <div v-if="errors.message" id="alert-error">
              {{ errors.message }}
            </div>
          </div>
          <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      remember: false,
      errors: {},
      logoSrc: '/img/logo_cms.png'
    };
  },
  methods: {
    async login() {
      this.errors = {};
      try {
        const response = await axios.post('/api/front/login', {
          email: this.email,
          password: this.password,
          remember: this.remember
        });

        const token = response.data.token;
        const user = response.data.user;
        const expiration = new Date().getTime() + 10 * 60 * 1000;

        localStorage.setItem('authToken', token);
        localStorage.setItem('user', JSON.stringify(user));
        localStorage.setItem('expiration', expiration);

        const userId = response.data.user.id;
        window.location.href = `/customer?id=${userId}`;

      } catch (error) {
        let message = error.response.data.error;
        if (message) {
          this.errors = { message };
        }
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        } else {
          console.error('Erro ao fazer login:', error);
        }

        setTimeout(() => {
          this.errors = {};
        }, 3000);
      }
    }
  }
};

</script>

<style scoped>
#alert-error {
  margin-top: 20px;
  padding: 10px;
  border: 1px solid #f5c6cb;
  background-color: #f8d7da;
  color: #721c24;
  border-radius: 0.25rem;
  font-size: 14px;
}
</style>