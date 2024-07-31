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
                <div class="form-group has-feedback" :class="{ 'form-group has-warning': errors.username }">
                  <input v-model="username" type="text" class="form-control" placeholder="Usuário" required autofocus>
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  <span v-if="errors.username" class="help-block">
                    <strong>{{ errors.username }}</strong>
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
      username: '',
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
          email: this.username,
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
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        } else {
          console.error('Erro ao fazer login:', error);
        }
      }
    }
  }
};
</script>

<style scoped></style>