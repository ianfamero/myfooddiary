<template>
  <div class="login">
    <el-row :gutter="20">
      <el-col :span="8" :offset="2">
        <el-card>
          <h2>Login</h2>
          <el-form label-width="120px">
            <el-form-item label="Email" :error="loginFormError.email">
              <el-input v-model="loginFormData.email"></el-input>
            </el-form-item>
            <el-form-item label="Password" :error="loginFormError.password">
              <el-input v-model="loginFormData.password" type="password"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="submitLoginForm">Login</el-button>
            </el-form-item>
          </el-form>
        </el-card>
      </el-col>
      <el-col :span="12">
        <el-card>
          <h2>Register</h2>
          <el-form label-position="top" v-loading="isProcessing" element-loading-text="Loading ...">
            <el-row :gutter="20">
              <el-col :span="12">
                <el-form-item label="Full Name" required :error="registerFormError.full_name">
                  <el-input type="text" v-model="registerFormData.full_name"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="Email" required :error="registerFormError.email">
                  <el-input type="email" v-model="registerFormData.email"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="Username" required :error="registerFormError.username">
                  <el-input type="text" v-model="registerFormData.username"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="Password" required :error="registerFormError.password">
                  <el-input type="password" v-model="registerFormData.password"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="24">
                <el-button type="primary" @click="submitRegisterForm">Register</el-button>
              </el-col>
            </el-row>
          </el-form>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        loginFormData: {
          email: '',
          password: '',
        },
        registerFormData: {
          full_name: '',
          email: '',
          username: '',
          password: '',
        },
        loginFormError: '',
        registerFormError: '',
      }
    },
    methods: {
      submitLoginForm: function() {
        axios.post("/login", this.loginFormData)
        .then(response=> {
          window.location.href = "";
        }).catch(error => {
          if (error.response.status == 401) {
            location.reload();
          }
          else if (error.response.status == 422) {
            this.formError = error.response.data;
          } else {
            this.$root.showMessage('error', error.response.data.message);
            this.formError = '';
          }
        });
      },
      submitRegisterForm: function() {
        axios.post("/register", this.registerFormData)
        .then(response => {

        }).catch(error => {

        })
      }
    }
  }
</script>