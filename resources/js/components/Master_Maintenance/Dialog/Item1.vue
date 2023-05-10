<template>
    <div>
        <v-dialog
            v-model="item1Dialog"
            persistent
            width="400px"
            transition="dialog-transition"
        >
            <v-toolbar dark color="#0548b2" dense style="font-size: 14px">
            <h3>Item 1</h3>
            <v-spacer></v-spacer>
            <v-btn @click="closeDialogItem1()" icon dense>
                <v-icon small>mdi-close</v-icon>
            </v-btn>
            </v-toolbar>
            <v-card tile flat height="auto">
            <br />
            <v-card-text>
                <v-text-field
                    v-model="tempObj.ITEM_1_CD"
                    onKeyPress="if(this.value.length==4)return false;"
                    dense
                    outlined
                    label="Code"
                    ></v-text-field>
                    <v-text-field
                    v-model="tempObj.ITEM_1_MEI"
                    dense
                    outlined
                    label="Item Name"
                    ></v-text-field>
                    <v-autocomplete
                    v-model="tempObj.ITEM_BUNRUI_CD"
                    :items="itemBunrui"
                    :item-text="setBunrui"
                    item-value="ITEM_BUNRUI_CD"
                    @change="setHaiban()"
                    dense
                    outlined
                >
                </v-autocomplete>
                <v-row>
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
                        v-model="tempObj.PICTURE_MISHUTSURYOKU"
                        dense
                        hide-details
                        label="画像"
                    ></v-checkbox>
                </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-btn
                    @click="saveItem1()"
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
        props: ["item1Dialog", "itemBunrui", "ObjItem1", "item1Status"],
        data() {
            return {
            tempObj: {},
            };
        },
        computed: {},
        watch: {
            item1Dialog(val) {
            if (val) {
                if (this.item1Status == "UPDATE") {
                this.tempObj = Object.assign({}, this.ObjItem1);
                }
            }
            },
        },

        created() {},

        methods: {
            setHaiban() {
            console.log("auto set haiban on comment");
            // if(this.tempObj.ITEM_BUNRUI_CD == 999){
            //   this.tempObj.HAIBAN = true;
            // }
            },
            setBunrui(item) {
            return `${item.ITEM_BUNRUI_CD}  ${item.ITEM_BUNRUI_MEI}`;
            },
            closeDialogItem1() {
            this.tempObj = {};
            this.$emit("closeDialogItem1", false);
            },
            saveItem1() {
            this.tempObj.HAIBAN = this.tempObj.HAIBAN == true ? 1 : 0;
            this.tempObj.PICTURE_MISHUTSURYOKU =
                this.tempObj.PICTURE_MISHUTSURYOKU == true ? 1 : 0;
            if (!this.tempObj.ITEM_1_CD) {
                alert("Please Insert Code");
            }
            if (!this.tempObj.ITEM_1_MEI) {
                alert("Please Insert Item Name");
            }
            if (this.item1Status == "ADD") {
                axios
                .post("/api/ExternalMaster/ItemMasterMaintenance/CheckItem1", this.tempObj)
                .then((r) => {
                    if (r.data.length != 0) {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Item Already Exist",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    } else {
                    axios
                        .post("/api/ExternalMaster/ItemMasterMaintenance/SaveItem1", this.tempObj)
                        .then((r) => {
                        if (r.data == "SAVED") {
                            Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Save Item",
                            showConfirmButton: false,
                            timer: 1500,
                            });
                            this.closeDialogItem1();
                        }
                        });
                    }
                });
            } else if (this.item1Status == "UPDATE") {
                if (!this.tempObj.ITEM_BUNRUI_CD) {
                this.tempObj.ITEM_BUNRUI_CD = "";
                }
                axios
                .post("/api/ExternalMaster/ItemMasterMaintenance/UpdateItem1", this.tempObj)
                .then((r) => {
                    if (r.data == "UPDATED") {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Update Item",
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    this.closeDialogItem1();
                    }
                });
            }
            },
        },
    };
</script>

<style lang="scss" scoped></style>
