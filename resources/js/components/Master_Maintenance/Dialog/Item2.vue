<template>
  <div>
    <v-dialog
      v-model="item2Dialog"
      persistent
      width="400px"
      transition="dialog-transition"
    >
      <v-toolbar dark color="#0548b2" dense style="font-size: 14px">
        <h3>{{ item2Status }} Item 2</h3>
        <v-spacer></v-spacer>
        <v-btn @click="closeDialogItem2()" icon dense>
          <v-icon small>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card tile flat height="auto">
        <br />
        <v-card-text>
          <v-text-field
            readonly
            v-model="tempObj.ITEM_1_CD"
            dense
            outlined
            label="コード 1"
          ></v-text-field>
          <v-text-field
            readonly
            v-model="tempObj.ITEM_1_MEI"
            dense
            outlined
            label="項目 1"
          ></v-text-field>
          <v-text-field
            :readonly="checkStatus()"
            v-model="tempObj.ITEM_2_CD"
            onKeyPress="if(this.value.length==4)return false;"
            dense
            outlined
            label="コード 2"
          ></v-text-field>
          <v-text-field
            v-model="tempObj.ITEM_2_MEI"
            dense
            outlined
            label="項目 2"
          ></v-text-field>
          <v-row>
            <v-col>
              <v-checkbox
                v-model="tempObj.INPUT_KBN"
                dense
                hide-details
                label="入力"
              ></v-checkbox>
            </v-col>
            <v-col>
              <v-checkbox
                v-model="tempObj.HAIBAN"
                dense
                hide-details
                label="廃番"
              ></v-checkbox>
            </v-col>
            <v-col>
              <v-checkbox
                v-model="tempObj.OUTPUT_KBN"
                dense
                hide-details
                label="出力"
              ></v-checkbox>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="4">
              <v-checkbox
                v-model="tempObj.PICTURE_MISHUTSURYOKU"
                dense
                hide-details
                label="画像"
              ></v-checkbox>
            </v-col>
            <v-col cols="8">
              <v-checkbox
                v-model="tempObj.CHK_LST_OUTPUT_KBN_1"
                dense
                hide-details
                label="チェックシート"
              ></v-checkbox>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <v-btn
            @click="saveItem2()"
            block
            dense
            color="primary"
            style="height: 35px !important"
            ><v-icon>mdi-content-save</v-icon>SAVE</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  import Swal from "sweetalert2";
  import axios from "axios";
  export default {
    props: ["item2Dialog", "item1Data", "item2Status", "ObjItem2", "newItem2"],
    data() {
      return {
        tempObj: {},
        tempObj2: {},
      };
    },
    computed: {},
    watch: {
      item2Dialog(val) {
        if (val) {
          if (this.item2Status == "ADD") {
            this.tempObj.ITEM_1_CD = this.item1Data.ITEM_1_CD;
            this.tempObj.ITEM_1_MEI = this.item1Data.ITEM_1_MEI;
          } else if (this.item2Status == "UPDATE") {
            this.tempObj = Object.assign({}, this.ObjItem2);
          }
        }
      },
    },
    created() {},
    methods: {
      saveItem2() {
        this.tempObj.HAIBAN = this.tempObj.HAIBAN == true ? 1 : 0;
        this.tempObj.INPUT_KBN = this.tempObj.INPUT_KBN == true ? 1 : 0;
        this.tempObj.OUTPUT_KBN = this.tempObj.OUTPUT_KBN == true ? 1 : 0;
        this.tempObj.PICTURE_MISHUTSURYOKU =
          this.tempObj.PICTURE_MISHUTSURYOKU == true ? 1 : 0;
        this.tempObj.CHK_LST_OUTPUT_KBN_1 =
          this.tempObj.CHK_LST_OUTPUT_KBN_1 == true ? 1 : 0;
        if (!this.tempObj.ITEM_2_CD) {
          alert("Please Enter Code 2");
          return false;
        }
        if (!this.tempObj.ITEM_2_CD) {
          alert("Please Enter Item Name 2");
          return false;
        }
        if (!this.tempObj.ITEM_BUNRUI_CD) {
          this.tempObj.ITEM_BUNRUI_CD = "";
        }
        if (this.item2Status == "ADD") {
          axios
            .post("/api/ExternalMaster/ItemMasterMaintenance/CheckItem2", this.tempObj)
            .then((r) => {
              if (r.data.length != 0) {
                alert("Existing Data");
              } else {
                axios
                  .post("/api/ExternalMaster/ItemMasterMaintenance/SaveItem2", this.tempObj)
                  .then((r) => {
                    if (r.data == "SAVED") {
                      axios
                        .post(
                          "/api/ExternalMaster/ItemMasterMaintenance/ReloadItem2",
                          this.tempObj
                        )
                        .then((r) => {
                          if (r.data.length != 0) {
                            Swal.fire({
                              position: "center",
                              icon: "success",
                              title: "Save Item",
                              showConfirmButton: false,
                              timer: 1500,
                            });
                            this.$emit("newItem2", r.data);
                          }
                        });
                    }
                  });
              }
            });
        } else if (this.item2Status == "UPDATE") {
          axios
            .post("/api/ExternalMaster/ItemMasterMaintenance/UpdateItem2", this.tempObj)
            .then((r) => {
              if (r.data == "UPDATED") {
                axios
                  .post(
                    "/api/ExternalMaster/ItemMasterMaintenance/ReloadItem2",
                    this.tempObj
                  )
                  .then((r) => {
                    if (r.data.length != 0) {
                      Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Item Updated",
                        showConfirmButton: false,
                        timer: 1500,
                      });
                      this.$emit("newItem2", r.data);
                    }
                  });
              }
            });
        }
      },
      checkStatus() {
        if (this.item2Status == "UPDATE") {
          return true;
        } else {
          return false;
        }
      },
      closeDialogItem2() {
        this.$emit("closeDialogItem2", false);
      },
    },
  };
</script>

<style scoped></style>
