<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="12" style="margin-bottom: 20px">
        <el-card>
          <h2>{{ userData.name + " - Profile" }}</h2>
          <el-form label-position="top" v-loading="isProcessing" element-loading-text="Loading ...">
            <el-row :gutter="20">
              <el-col :span="12">
                <el-form-item label="Gender" required :error="formError.gender_id">
                  <el-select v-model="formData.gender_id" placeholder="Select" filterable style="width: 100%">
                    <el-option v-for="gender in genders" :key="gender.id" :label="gender.gender" :value="gender.id">
                    </el-option>
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="Age" required :error="formError.age">
                  <el-input type="text" v-model="formData.age"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="Height (cm)" required :error="formError.height">
                  <el-input type="text" v-model="formData.height"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="Weight (kg)" required :error="formError.weight">
                  <el-input type="text" v-model="formData.weight"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="Activity" required :error="formError.activity_id">
                  <el-select v-model="formData.activity_id" placeholder="Select" filterable style="width: 100%">
                    <el-option v-for="act in activity" :key="act.id" :label="act.activity" :value="act.id">
                    </el-option>
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item label="Diet Type" required :error="formError.diet_type_id">
                  <el-select v-model="formData.diet_type_id" placeholder="Select" filterable style="width: 100%">
                    <el-option v-for="diet_type in diet_types" :key="diet_type.id" :label="diet_type.diet" :value="diet_type.id">
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
      <el-col :xs="24" :sm="12">
        <el-card v-loading="isProcessing" element-loading-text="Loading ...">
          <h2>Summary</h2>
          <el-table :data="summaryData" style="width: 100%">
            <el-table-column prop="target" label="Target" min-width="130"> </el-table-column>
            <el-table-column prop="calories" label="Calories" min-width="100"> </el-table-column>
            <el-table-column prop="carb" label="Carbs (g)" min-width="100">
              <template slot-scope="scope">
                {{ scope.row.carb + ' g' }}
              </template>
            </el-table-column>
            <el-table-column prop="fat" label="Fat (g)" min-width="100">
              <template slot-scope="scope">
                {{ scope.row.fat + ' g' }}
              </template>
            </el-table-column>
             <el-table-column prop="protein" label="Protein (g)" min-width="110"> 
              <template slot-scope="scope">
                {{ scope.row.protein + ' g' }}
              </template>
            </el-table-column>
          </el-table>

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
        userData: [],
        summaryData: [],
        formError: '',
        isProcessing: false,
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
          diet_type_id: '',
        }
      },
      getDatas: function() {
        this.isProcessing = true;
        axios.get(URL + 'get-datas')
        .then(response => {
          this.isProcessing = false;
          this.genders = response.data.genders;
          this.activity = response.data.activity;
          this.diet_types = response.data.diet_types;
          this.formData = response.data.profile[0].profile;
          this.userData = response.data.profile[0];
          this.summaryData = response.data.summary;
        }).catch(error => {
          this.isProcessing = false;
        });
      },
      submitForm: function() {
        this.isProcessing = true;
        axios.post(URL + 'save', this.formData)
        .then(response => {
          this.getDatas();
          this.isProcessing = false;
          this.$root.showMessage('success', response.data.message);
          this.formError = '';
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
          this.isProcessing = false;
        });
      }
    }
  }

</script>