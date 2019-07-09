<template>
  <div class="login">
    <el-row :gutter="20">
      <el-col :span="11" :offset="3">
        <el-card>
          <h2>My Food Diary</h2>
          <p>My Food Diary helps you monitor your daily calorie intake for a healthy weight-loss journey.</p>
        </el-card>
      </el-col>
      <el-col :span="7">
        <el-card>
          <el-tabs type="card">
            <el-tab-pane label="Login">
              <el-form label-position="top" v-loading="isProcessing" element-loading-text="Loading ...">
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
            </el-tab-pane>
            <el-tab-pane label="Register">
              <el-form label-position="top" v-loading="isProcessing" element-loading-text="Loading ...">
                <el-form-item label="Full Name" required :error="registerFormError.name">
                  <el-input type="text" v-model="registerFormData.name"></el-input>
                </el-form-item>
                <el-form-item label="Email" required :error="registerFormError.email">
                  <el-input type="email" v-model="registerFormData.email"></el-input>
                </el-form-item>
                <el-form-item label="Username" required :error="registerFormError.username">
                  <el-input type="text" v-model="registerFormData.username"></el-input>
                </el-form-item>
                <el-form-item label="Password" required :error="registerFormError.password">
                  <el-input type="password" v-model="registerFormData.password"></el-input>
                </el-form-item>
                <el-button type="primary" @click="submitRegisterForm">Register</el-button>
              </el-form>
            </el-tab-pane>
          </el-tabs>
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
          name: '',
          email: '',
          username: '',
          password: '',
          profile_id: '',
        },
        loginFormError: '',
        registerFormError: '',
        isProcessing: false,
      }
    },
    created() {
      document.title = 'My Food Diary';
    },
    methods: {
      submitLoginForm: function() {
        axios.post("/login", this.loginFormData)
        .then(response=> {
          window.location.href = "/food-diary";
          this.loginFormError = '';
        }).catch(error => {
          if (error.response.status == 401) {
            location.reload();
          }
          else if (error.response.status == 422) {
            this.loginFormError = error.response.data;
          } else {
            this.$root.showMessage('error', error.response.data.message);
            this.loginFormError = '';
          }
        });
      },
      submitRegisterForm: function() {
        this.isProcessing = true;
        axios.post("/register", this.registerFormData)
        .then(response => {
          this.isProcessing = false;
          this.registerFormData.name = this.registerFormData.email =this.registerFormData.username = this.registerFormData.password = this.registerFormData.profile_id = "";
          this.$root.showMessage('success', response.data.message);
          this.registerFormError = '';
        }).catch(error => {
          if (error.response.status == 401) {
            location.reload();
          }
          else if (error.response.status == 422) {
            this.registerFormError = error.response.data;
          } else {
            this.$root.showMessage('error', error.response.data.message);
            this.registerFormError = '';
          }
          this.isProcessing = false;
        })
      }
    }
  }
</script>