<template>
    <div>
        <v-dialog
        v-model="dialog"
        persistent
        width="400px"
        transition="dialog-transition"
        >
        <v-toolbar  dark color="#0548b2" dense style="font-size: 14px">
            <h3>Item 1</h3>
            <v-spacer></v-spacer>
            <v-icon>mdi-close</v-icon>
        </v-toolbar>
            <v-card>
                <v-card-title>
                    <v-text-field dense outlined></v-text-field>
                    <v-text-field dense outlined></v-text-field>
                </v-card-title>
                <v-card-actions>
                    <v-btn></v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        props:['dialog'],
        data() {
            return {
            }
        },
        watch: {

        },
    }
</script>

<style lang="scss" scoped>

</style>