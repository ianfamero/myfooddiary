<template>
  <div>
    <el-row :gutter="20">
      <el-col :xs="24" :sm="7">
        <el-card>
          <el-form>
            <!-- <el-row :gutter="20">
              <el-col :span="12"> -->
                <el-form-item label="From" :error="formError.date_from">
                  <el-date-picker type="date" placeholder="From" format="MMMM d, yyyy" value-format="yyyy/MM/dd"
                    v-model="formData.date_from" :clearable="false" style="width: 100%;"></el-date-picker>
                </el-form-item>
              <!-- </el-col>
              <el-col :span="12"> -->
                <el-form-item label="To" :error="formError.date_to">
                  <el-date-picker type="date" placeholder="To" format="MMMM d, yyyy" value-format="yyyy/MM/dd"
                    v-model="formData.date_to" :clearable="false" style="width: 100%;"></el-date-picker>
                </el-form-item>
              <!-- </el-col>
            </el-row> -->
            <el-button type="primary" @click="submitForm"><i class="fa fa-file-o"></i> Generate</el-button>
            <el-button type="success"><i class="fa fa-print"></i> Print</el-button>
          </el-form>
        </el-card><br>
      </el-col>
      <el-col :xs="24" :sm="17">
        <el-card v-loading="isProcessing" element-loading-text="Loading ...">
          <el-table :data="summaryData" style="width: 100%" sortable>
            <el-table-column prop="date" label="Date" min-width="100">
              <template slot-scope="scope">
                {{ scope.row.date | dateFormat }}
              </template>
            </el-table-column>
            <el-table-column prop="calories" label="Calories" min-width="80"> </el-table-column>
            <el-table-column prop="carb" label="Carb (g)" min-width="80">
              <template slot-scope="scope">
                {{ scope.row.carb + ' g' }}
              </template>
            </el-table-column>
            <el-table-column prop="fat" label="Fat (g)" min-width="80">
              <template slot-scope="scope">
                {{ scope.row.fat + ' g' }}
              </template>
            </el-table-column>
            <el-table-column prop="protein" label="Protein (g)" min-width="80">
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
var URL = "/report/";
export default {
  data() {
    return {
      summaryData: [],
      formData: this.initFormData(),
      targets: [
        {
          id: 0,
          name: 'Maintain Weight'
        },
        {
          id: 1,
          name: 'Lose Weight'
        },
        {
          id: 2,
          name: 'Lose Weight Fast'
        },
      ],
      formError: '',
      isProcessing: false,
    }
  },
  created() {
    document.title = "Reports";
  },
  methods: {
    initFormData: function() {
      return {
        date_from: '',
        date_to: '',
        target_id: '',
      }
    },
    submitForm: function() {
      this.isProcessing = true;
      axios.post(URL + "generate", this.formData)
      .then(response=> {
        this.summaryData = response.data;
        this.isProcessing = false;
      }).catch(error=> {
        this.isProcessing = false;
      });
    }
  }
}
</script>
