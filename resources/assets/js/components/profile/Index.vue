<template>
  <div>
    <el-row>
      <el-col :span="12" :offset="6">
        <el-card>
          <el-form>
            <el-row :gutter="20">
              <el-col :span="24">
                <el-form-item label="Gender" required :error="formError.gender">
                  <el-select v-model="formData.gender_id" placeholder="Select" filterable style="width: 100%">
                    <el-option v-for="gender in genders" :key="gender.id" :label="gender.gender" :value="gender.id">
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item label="Age" required :error="formError.age">
                  <el-input type="text" v-model="formData.age"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="Height" required :error="formError.height">
                  <el-input type="text" v-model="formData.height"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="Weight" required :error="formError.weight">
                  <el-input type="text" v-model="formData.weight"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="24">
                <el-form-item label="Activity" required :error="formError.activity">
                  <el-select v-model="formData.activity_id" placeholder="Select" filterable style="width: 100%">
                    <el-option v-for="act in activity" :key="act.id" :label="act.activity" :value="act.id">
                    </el-option>
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="24">
                <el-button type="primary" @click="submitForm"><i class="fa fa-save"></i> Save</el-button>
              </el-col>
            </el-row>
          </el-form>
        </el-card>
      </el-col>
    </el-row><br>
    <el-row>
      <el-col :span="12" :offset="6">
        <el-card>
          <h2>Summary</h2>
          <p>Maintain Weight: {{ formData.maintain_weight }}</p>
          <p>Lose Weight: {{ formData.lose_weight }}</p>
          <p>Lose Weight Fast: {{ formData.lose_weight_fast }}</p>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  var URL = '/profile/'
  export default {
    data() {
      return {
        genders: [],
        activity: [],
        formData: this.initFormData(),
        formError: '',
      }
    },
    created() {
      document.title = 'Profile';
      this.getDatas();
    },
    methods: {
      initFormData: function() {
        return {
          gender_id: '',
          age: '',
          weight: '',
          height: '',
          activity_id: '',
        }
      },
      getDatas: function() {
        axios.get(URL + 'get-datas')
        .then(response => {
          this.genders = response.data.genders;
          this.activity = response.data.activity;
          this.formData = response.data.profile[0];
        }).catch(error => {

        });
      },
      submitForm: function() {
        axios.post(URL + 'save', this.formData)
        .then(response => {

        }).catch(error => {

        });
      }
    }
  }

</script>