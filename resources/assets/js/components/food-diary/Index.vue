<template>
  <div>
    <el-row :gutter="20">
      <el-col :sm="24" :lg="8">
        <el-card>
          <el-form label-position="top" v-loading="isProcessing" element-loading-text="Loading ...">
            <el-form-item label="Date" :error="formError.date" required>
            <el-date-picker type="date" placeholder="Date" format="MMMM d, yyyy" value-format="yyyy/MM/dd"
                v-model="formData.date" :clearable="false" style="width: 100%;" @change="getDatas"></el-date-picker>
          </el-form-item>
          <el-form-item label="Meal Type" required :error="formError.meal_type_id">
            <el-select v-model="formData.meal_type_id" placeholder="Select" filterable style="width: 100%">
              <el-option v-for="meal in meal_types" :key="meal.id" :label="meal.meal_type" :value="meal.id">
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="Food" required :error="formError.food_list_id">
            <el-select v-model="formData.food_list_id" placeholder="Select" filterable style="width: 100%">
              <el-option v-for="food in food_list" :key="food.id" :label="food.food + ' (' + food.calories + ' calories)'" :value="food.id">
              </el-option>
            </el-select>
          </el-form-item>
          <el-button type="primary" @click="submitForm"><i class="fa fa-plus"></i> Add</el-button>
          </el-form>
        </el-card>
      </el-col>
      <el-col :sm="24" :lg="16">
        <el-card v-loading="isProcessing" element-loading-text="Loading ...">
          <div class="table-header"><b>BREAKFAST</b></div>
          <el-table :data="food_intake[0]" border stripe>
            <el-table-column sortable prop="food_list.food" label="Food" min-width="180"></el-table-column>
            <el-table-column sortable prop="food_list.serving_size" label="Serving Size" min-width="180"></el-table-column>
            <el-table-column sortable prop="food_list.calories" label="Calories" min-width="180"></el-table-column>
            <el-table-column width="80" fixed="right">
              <template slot-scope="scope">
                <el-button type="danger" @click.native="toDestroy(scope.row.id, scope.row.food_list.food, false, 0)"><i class="fa fa-trash-o"></i></el-button>
              </template>
            </el-table-column>
          </el-table>
          <div class="table-header"><b>LUNCH</b></div>
          <el-table :data="food_intake[1]" border stripe>
            <el-table-column sortable prop="food_list.food" label="Food" min-width="180"></el-table-column>
            <el-table-column sortable prop="food_list.serving_size" label="Serving Size" min-width="180"></el-table-column>
            <el-table-column sortable prop="food_list.calories" label="Calories" min-width="180"></el-table-column>
            <el-table-column width="80" fixed="right">
              <template slot-scope="scope">
                <el-button type="danger" @click.native="toDestroy(scope.row.id, scope.row.food_list.food, false, 1)"><i class="fa fa-trash-o"></i></el-button>
              </template>
            </el-table-column>
          </el-table>
          <div class="table-header"><b>DINNER</b></div>
          <el-table :data="food_intake[2]" border stripe>
            <el-table-column sortable prop="food_list.food" label="Food" min-width="180"></el-table-column>
            <el-table-column sortable prop="food_list.serving_size" label="Serving Size" min-width="180"></el-table-column>
            <el-table-column sortable prop="food_list.calories" label="Calories" min-width="180"></el-table-column>
            <el-table-column width="80" fixed="right">
              <template slot-scope="scope">
                <el-button type="danger" @click.native="toDestroy(scope.row.id, scope.row.food_list.food, false, 2)"><i class="fa fa-trash-o"></i></el-button>
              </template>
            </el-table-column>
          </el-table>
          <div class="table-header"><b>SNACK</b></div>
          <el-table :data="food_intake[3]" border stripe>
            <el-table-column sortable prop="food_list.food" label="Food" min-width="180"></el-table-column>
            <el-table-column sortable prop="food_list.serving_size" label="Serving Size" min-width="180"></el-table-column>
            <el-table-column sortable prop="food_list.calories" label="Calories" min-width="180"></el-table-column>
            <el-table-column width="80" fixed="right">
              <template slot-scope="scope">
                <el-button type="danger" @click.native="toDestroy(scope.row.id, scope.row.food_list.food, false, 3)"><i class="fa fa-trash-o"></i></el-button>
              </template>
            </el-table-column>
          </el-table>

          <p>Maintain Weight: <b>{{ total_calories_today }} / {{ profile[0].maintain_weight }}</b></p>
          <p>Lose Weight: <b>{{ total_calories_today }} / {{ profile[0].lose_weight }}</b></p>
          <p>Lose Weight Fast: <b>{{ total_calories_today }} / {{ profile[0].lose_weight_fast }}</b></p>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  var URL = '/food-diary/';
  export default {
    data() {
      return {
        meal_types: [],
        food_list: [],
        food_intake: [],
        profile: [],
        total_calories_today: 0,
        table_index: '',
        formError: '',
        isProcessing: false,
        formData: this.initFormData(),
      }
    },
    created() {
      document.title = 'Food Diary';
      this.getDatas();
      this.$root.$on('destroy', this.destroy);
    },
    beforeDestroy() {
      this.$root.$off('destroy', this.destroy);
    },
    methods: {
      initFormData: function() {
        return {
          date: this.getDate(),
          meal_type_id: '',
          food_list_id: '',
          profile_id: 1,
        }
      },
      getDate: function() {
        return moment(new Date()).format("YYYY/MM/DD");
      },
      getDatas: function() {
        this.isProcessing = true;
        axios.post(URL + 'get-datas', this.formData)
        .then(response => {
          this.meal_types = response.data.meal_types;
          this.food_list = response.data.food_list;
          this.food_intake = response.data.food_intake;
          this.total_calories_today = response.data.total_calories_today;
          this.profile = response.data.profile;
          this.isProcessing = false;
        }).catch(error => {
          this.isProcessing = false;
        });
      },
      submitForm: function() {
        axios.post(URL + 'add', this.formData)
        .then(response => {
          this.getDatas();
        }).catch(error => {

        });
      },
      toDestroy: function (id, code, isMany, tableIndex) {
        this.table_index = tableIndex;
        if (this.isProcessing == false) {
          this.$root.destroyMessage(id, code, isMany);
        }
      },
      destroy: function (id) {
        this.isProcessing = true;
        axios.get(URL + 'destroy/' + id)
        .then (response => {
          this.isProcessing = false;
          this.getDatas();
          let originalIndex = _.findIndex(this.food_intake[this.table_index], { 'id' : id});
          this.food_intake[this.table_index].splice(originalIndex, 1);
          this.$root.showMessage('success', response.data);
        }) .catch (error => {
          if (error.response.status == 401) {
            location.reload();
          } else {
            this.isProcessing = false;
            this.$root.showMessage('error', error.response.data.message);
          }
        });
      },
    }
  }

</script>