<template>
  <el-dialog title="External Food Databases" :visible.sync="isShowModal" :close-on-click-modal="false"
    show-close :modal-append-to-body="false" top="1em" width="80%" custom-class="fw-modal" :close-on-press-escape="false">
    <el-form>
        <el-row :gutter="20">
          <el-col :xs="9" :sm="6">
            <el-form-item required :error="formError.food_database">
              <el-select v-model="formData.food_database" placeholder="Select" filterable :clearable="false" style="width: 100%;">
                <el-option v-for="fd in foodDatabases" :key="fd.id" :label="fd.name" :value="fd.id">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :xs="9" :sm="10">
            <el-form-item>
              <el-input type="text" v-model="formData.search_query"></el-input>
            </el-form-item>
          </el-col>
          <el-col :xs="6" :sm="6">
            <el-form-item>
              <el-button @click="search" type="primary" size="mini" :disabled="isProcessing">Search</el-button>
            </el-form-item>
          </el-col>
        </el-row>
      </el-form>
      <el-table :data="results" border stripe empty-text="No Data Found" v-loading="isProcessing" :default-sort="{prop: 'food', order: 'ascending'}" element-loading-text="Loading ..." style="width: 100%">
        <el-table-column sortable prop="food" label="Food" min-width="250"></el-table-column>
        <el-table-column sortable prop="serving_size" label="Serving Size" width="120"></el-table-column>
        <el-table-column sortable prop="calories" label="Calories" width="100"></el-table-column>
        <el-table-column sortable prop="carb" label="Carb (g)" width="100">
          <template slot-scope="scope">
            {{ scope.row.carb + ' g' }}
          </template>
        </el-table-column>
        <el-table-column sortable prop="fat" label="Fat (g)" width="100">
          <template slot-scope="scope">
            {{ scope.row.fat + ' g' }}
          </template>
        </el-table-column>
        <el-table-column sortable prop="protein" label="Protein (g)" width="110">
          <template slot-scope="scope">
            {{ scope.row.protein + ' g' }}
          </template>
        </el-table-column>
        <el-table-column width="100" fixed="right">
          <template slot-scope="scope">
            <el-button  @click.native="addFood(scope.row)" type="primary" size="mini"><i class="fa fa-plus"></i> Add</el-button>
          </template>
        </el-table-column>
      </el-table><br>
      Powered by <a href="http://www.nutritionix.com/api" target="_blank">Nutritionix API</a> and <a href="" target="_blank">USDA API</a>
  </el-dialog>
</template>

<script>
  var URL = '/food-list/external-food-databases/';
  export default {
    data() {
      return {
        results: [],
        foodDatabases: [
          {
            id: 0,
            name: 'USDA'
          },
          {
            id: 1,
            name: 'Nutritionix'
          }
        ],
        formData: this.initFormData(),
        formError: '',
        isShowModal: false,
        isProcessing: false,
      }
    },
    methods: {
      initFormData: function() {
        return {
          search_query: '',
          food_database: '',
        }
      },
      search: function() {
        this.isProcessing = true;
        axios.post(URL + 'search', this.formData)
        .then(response => {
          this.results = response.data;
          this.formError = '';
          this.isProcessing = false;
        }).catch(error=> {
          if (error.response.status == 401) {
            location.reload();
          }
          else if (error.response.status == 422) {
            this.formError = error.response.data;
          } else {
            this.formError = '';
          }
          this.isProcessing = false;
        });
      },
      addFood: function(data) {
        axios.post(URL + 'new', data)
        .then(response => {
          this.$root.showMessage('success', data.food + ' ' + response.data.message);
        }).catch(error=> {
          if (error.response.status == 401) {
            location.reload();
          }
          else if (error.response.status == 422) {
            this.formError = error.response.data;
          } else {
            this.$root.showMessage('error', error.response.data.message);
          }
        });
      },
      showModal: function (data) {
        Vue.nextTick(() => this.isShowModal = true);
      },
    }
  }
</script>