<template>
  <div>
    <el-row>
      <el-col :span="24">
        <el-card>
          <el-row class="mb-15">
            <el-button type="primary" size="mini" @click="showModal('')" :disabled="isProcessing"> New</el-button>&nbsp;&nbsp;or
            <el-button type="primary" size="mini" @click="showNutritionixModal()" :disabled="isProcessing">Search Nutritionix</el-button>
            <el-button type="danger" size="mini" @click="toDestroy('', 'selected', true)" :disabled="multipleSelection.length == 0 || isProcessing"> Delete</el-button>
          </el-row>
          <el-row>
            <div class="table-header">
              <el-col :xs="6" :sm="14">
                <el-tooltip effect="dark" content="Refresh Table" placement="bottom">
                  <el-button size="mini" class="export-button" @click="getDatas" :disabled="isProcessing">
                    <i class="fa fa-refresh fa-lg text-blue"></i>
                  </el-button>
                </el-tooltip>
              </el-col>
              <el-col :xs="18" :sm="10">
                <el-input v-model="search" placeholder="Search" class="input-with-select text-right">
                  <el-select v-model="searchIn" slot="prepend" placeholder="Select" style="width: 100px" filterable>
                    <el-option v-for="s in searchFields" :key="s.value" :value="s.value" :label="s.label"></el-option>
                  </el-select>
                </el-input>
              </el-col>
            </div>
            <el-row class="mb-15">
              <el-table :data="paginatedFoodList" border stripe empty-text="No Data Found" v-loading="isProcessing" 
                @sort-change="handleSortChange" :default-sort="{prop: 'food', order: 'ascending'}" element-loading-text="Loading ..." @selection-change="handleSelectionChange" style="width: 100%">
                <el-table-column sortable type="selection" width="45"></el-table-column>
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
                <el-table-column width="120" fixed="right">
                  <template slot-scope="scope">
                    <el-dropdown trigger="click">
                      <el-button type="primary" size="mini">
                        Options <i class="el-icon-caret-bottom el-icon--right"></i>
                      </el-button>
                      <el-dropdown-menu slot="dropdown">
                        <!-- <el-dropdown-item @click.native="showDetailsModal(scope.row.id)"><i class="fa fa-eye"></i> Show</el-dropdown-item> -->
                        <el-dropdown-item @click.native="showModal(scope.row)"><i class="fa fa-edit"></i> Edit</el-dropdown-item>
                        <el-dropdown-item @click.native="toDestroy(scope.row.id, scope.row.food, false)"><i class="fa fa-trash-o"></i> Delete</el-dropdown-item>
                      </el-dropdown-menu>
                    </el-dropdown>
                  </template>
                </el-table-column>
              </el-table>
            </el-row>
            <el-row class="text-center">
              <el-pagination
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page.sync="currentPage"
                :page-sizes="[10, 20, 50, 100]"
                :page-size="currentSize"
                layout="total, sizes, prev, pager, next"
                :total="currentTotal">
              </el-pagination>
            </el-row>
          </el-row>
        </el-card>
      </el-col>
    </el-row>
    <food-list-nutritionix-modal ref="nutritionix"></food-list-nutritionix-modal>
    <food-list-form-modal ref="foodlist"></food-list-form-modal>
  </div>
</template>

<script>
  var URL = '/food-list/'
  export default {
    data() {
      return {
        food_list: [],
        isProcessing: false,
        multipleSelection: [],
        currentPage: 1,
        currentSize: 10,
        currentTotal: 1,
        orderBy: null,
        orderName: null,
        search: '',
        searchFields: [
          {label: 'Food' , value: 'food' },
        ],
        searchIn: 'food',
      }
    },
    created() {
      document.title = 'Food List';
      this.getDatas();
      this.$root.$on('destroy', this.destroy);
      this.$root.$on('destroySelected', this.destroySelected);
    },
    beforeDestroy() {
      this.$root.$off('destroy', this.destroy);
      this.$root.$off('destroySelected', this.destroySelected);
    },
    computed: {
      paginatedFoodList() {
        let filtered = this.food_list;

        if(this.search != "") {
          let searchIn = this.searchIn.toLowerCase();
          let search = this.search.toLowerCase();

          filtered = _.filter(filtered, function (m) {
            let value = m[searchIn] == null ? '' : m[searchIn].toLowerCase();
            return value.indexOf(search) !== -1;
          });
        }

        this.currentTotal = filtered.length;
        return _.slice( _.orderBy(filtered, this.orderName, this.orderBy), (this.currentPage * this.currentSize) - this.currentSize, (this.currentPage * this.currentSize) );
      }
    },
    methods: {
      handleSizeChange: function (val) {
        this.currentSize = val;
      },
      handleCurrentChange: function (val) {
        this.currentPage = val;
      },
      handleSortChange: function (col) {
        this.orderName = col.prop;
        this.orderBy = col.order == 'ascending' ? 'asc' : 'desc';
      },
      handleSelectionChange: function(val) {
        this.multipleSelection = [];
        for (let index in val) {
          this.multipleSelection.push(val[index].id);
        }
      },
      getDatas: function() {
        this.isProcessing = true;
        axios.get(URL + 'get-datas')
        .then(response => {
          this.food_list = response.data;
          this.isProcessing = false;
        }).catch(error => {
          this.isProcessing = false;
        });
      },
      toDestroy: function (id, code, isMany) {
        if (this.isProcessing == false) {
          this.$root.destroyMessage(id, code, isMany);
        }
      },
      destroy: function (id) {
        this.isProcessing = true;
        axios.get(URL + 'destroy/' + id)
        .then (response => {
          this.isProcessing = false;
          let originalIndex = _.findIndex(this.food_list, { 'id' : id});
          this.food_list.splice(originalIndex, 1);
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
      destroySelected: function() {
        this.isProcessing = true;
        axios.post(URL + 'destroy-selected', this.multipleSelection)
        .then (response => {
          this.isProcessing = false;
          _.forEach(this.multipleSelection, (value, key) => {
            let originalIndex = _.findIndex(this.food_list, { 'id' : value});
            this.food_list.splice(originalIndex, 1);
          });
          this.multipleSelection = [];
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
      showModal: function(data) {
        this.$refs.foodlist.showModal(data);
      },
      showNutritionixModal: function() {
        this.$refs.nutritionix.showModal();
      },
    }
  }

</script>