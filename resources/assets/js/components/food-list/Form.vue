<template>
  <el-dialog :title="(formMode == 'store' ? 'New' : 'Update') + ' - Food'" :visible.sync="isShowModal" :close-on-click-modal="false"
    :show-close="false" :modal-append-to-body="false" top="1em" width="50%" :close-on-press-escape="false">
    <el-form label-position="top" v-loading="isProcessing" element-loading-text="Processing ...">
      <el-row :gutter="20">
        <el-col :span="24">
          <el-form-item label="Food" required :error="formError.food">
            <el-input type="text" v-model="formData.food"></el-input>
          </el-form-item>
          <el-form-item label="Serving Size" required :error="formError.serving_size">
            <el-input type="text" v-model="formData.serving_size"></el-input>
          </el-form-item>
          <el-form-item label="Calories" required :error="formError.calories">
            <el-input type="text" v-model="formData.calories"></el-input>
          </el-form-item>
        </el-col>
      </el-row>
    </el-form>
    <span slot="footer">
      <el-button @click="submitForm" type="primary" size="mini" :disabled="isProcessing" :class="formMode == 'store' ? 'btn-store' : 'btn-edit'">
        {{ formMode == "store" ? "Save" : "Update" }}
      </el-button>
      <el-button size="mini" @click="isShowModal = false" :disabled="isProcessing" class="btn-close">Close</el-button>
    </span>
  </el-dialog>
</template>

<script>
  var URL = '/food-list/';
  export default {
    data() {
      return {
        formData: this.initFormData(),
        formError: '',
        formMode: '',
        formIndex: '',
        isShowModal: false,
        isProcessing: false,
      }
    },
    methods: {
      initFormData: function() {
        return {
          food: '',
          serving_size: '',
          calories: '',
          profile_id: '',
        }
      },
      submitForm: function() {
        this.isProcessing = true;
        let postUrl = this.formMode == 'store' ? URL + 'new' : URL + 'edit/' + this.formData.id;
        axios.post(postUrl, this.formData)
        .then(response => {
          this.isProcessing = false;
          this.$root.showMessage('success', this.formData.food + ' ' + response.data.message);
          if (this.formMode == 'store') {
            this.$parent.food_list.push(response.data.food_list);
          } else {
            _.assign(this.$parent.food_list[this.formIndex], this.formData);
          }
          this.formError = '';
          this.isShowModal = false;
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
      },
      showModal: function (data) {
        this.formMode = data === '' ? 'store' : 'update';
        if (this.formMode == 'store') {
          this.formData = this.initFormData();
        } else {
          this.formIndex = _.findIndex(this.$parent.food_list, {'id' : data.id});
          this.formData = Object.assign({}, data);
        }
        this.formError = '';
        Vue.nextTick(() => this.isShowModal = true);
      },
    }
  }
</script>