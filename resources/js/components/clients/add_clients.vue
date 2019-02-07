<template>
    <v-layout row wrap>
        <v-toolbar color="cyan lighten-2" dark>
            <v-icon dark right>chrome_reader_mode</v-icon>
            <v-toolbar-title>Add Client</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="red" :to="{name:'manage_client'}">
                <v-icon>keyboard_backspace</v-icon>
            </v-btn>
        </v-toolbar>

        <v-flex xs12>
            <v-card color="blue-grey darken-2" class="white--text">
                <v-card-title >

                </v-card-title>
                <v-container
                    fill-height
                    fluid
                    pa-2
                >
                    <v-layout fill-height>
                        <v-flex xs12 align-end flexbox>
                            <v-form v-model="valid">
                                <v-text-field
                                    v-model="Client.acc_no"
                                    :rules="required_rules"
                                    :counter="15"
                                    label="Account No"
                                    required
                                    readonly
                                    solo-inverted

                                    class="mx-3"
                                >

                                </v-text-field>

                                <v-text-field
                                    v-model="Client.name"
                                    :rules="required_rules"
                                    :counter="20"
                                    label="Name"
                                    required
                                    solo-inverted
                                    class="mx-3"
                                ></v-text-field>

                                <v-text-field
                                    v-model="Client.mobile"
                                    :counter="15"
                                    label="Mobile"
                                    required
                                    solo-inverted
                                    class="mx-3"
                                ></v-text-field>
                                <v-text-field
                                    v-model="Client.phone"
                                    :counter="15"
                                    label="Phone"
                                    required
                                    solo-inverted
                                    class="mx-3"
                                ></v-text-field>
                                <v-text-field
                                    v-model="Client.email"
                                    :counter="15"
                                    label="Email"
                                    required
                                    solo-inverted
                                    class="mx-3"
                                ></v-text-field>
                                <v-text-field
                                    v-model="Client.address"
                                    :counter="50"
                                    label="Address"
                                    required
                                    solo-inverted
                                    class="mx-3"
                                ></v-text-field>
                                <!--Profile Pic-->
                                <img :src="imageUrl" height="150" v-if="imageUrl"/>
                                <v-text-field label="Select Profile Pic" @click='pickFile' v-model='imageName' prepend-icon='attach_file'></v-text-field>
                                <input
                                    type="file"
                                    style="display: none"
                                    ref="image"
                                    accept="image/*"
                                    @change="onFilePicked"
                                >
                                <!--Nid Pic-->
                                <img :src="nid.imageUrl" height="150" v-if="nid.imageUrl"/>
                                <v-text-field label="Select NID" @click='pickNID' v-model='nid.imageName' prepend-icon='attach_file'></v-text-field>
                                <input
                                    type="file"
                                    style="display: none"
                                    ref="nid_image"
                                    accept="image/*"
                                    @change="onNIDPicked"
                                ><!--Sign Pic-->
                                <img :src="sign.imageUrl" height="150" v-if="sign.imageUrl"/>
                                <v-text-field label="Select Sign" @click='picksign' v-model='sign.imageName' prepend-icon='attach_file'></v-text-field>
                                <input
                                    type="file"
                                    style="display: none"
                                    ref="sign_image"
                                    accept="image/*"
                                    @change="onsignPicked"
                                >
                                <v-select
                                    :items="client_type"
                                    v-model="Client.type"
                                    solo-inverted
                                    class="mx-3"
                                    label="Client Type"
                                    :messages="['Client Type']"
                                ></v-select>

                            </v-form>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <v-btn class="mx-3" solo-inverted v-if="!this.edit && this.valid"  @click="add_Client" color="primary">Add</v-btn>
                    <v-btn class="mx-3" solo-inverted v-else-if="this.edit && this.valid" color="success" @click="update_Client">Update</v-btn>
                    <v-btn class="mx-3" solo-inverted v-if="this.edit" @click="delete_Client" color="error">Delete</v-btn>

                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "add_Client",
        data: () => ({

            //---------------------------
            hasSaved: false,
            model: null,
            wards: [

            ],
            //------------


            valid: false,
            required_rules: [
                v => !!v || 'required',
            ],
            edit:false,
            Client:{
                id:"",
                acc_no:"",
                name:'',
                mobile:"",
                phone:"",
                email:"",
                address:"",
                profile_pic:"",
                id_card:"",
                signature:"",
                client_type:"",
                delete:false,
            },
            client_type:[
                'general',
                'company'
            ],

            imageName: '',
            imageUrl: '',
            imageFile: '',

            nid:{

                imageName: '',
                imageUrl: '',
                imageFile: ''
            },
            sign:{

                imageName: '',
                imageUrl: '',
                imageFile: ''
            }




        }),
        created(){
            var url=location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '')+'/data/';
            if(this.$route.params.id!==undefined) {
                fetch('/system/client/'+this.$route.params.id)
                    .then(res=>res.json())
                    .then(res=>{
                            this.Client.id=res.id;
                            this.Client.acc_no=res.acc_number;
                            this.Client.name=res.name;
                            this.Client.mobile=res.mobile;
                            this.Client.phone=res.phone;
                            this.Client.email=res.email;
                            this.Client.address=res.address;
                            this.Client.client_type=res.client_type;



                        this.imageUrl=url+res.profile_pic;
                        this.nid.imageUrl=url+res.id_card;
                        this.sign.imageUrl=url+res.signature;
                    });
                this.edit = true;

            }else{
                this.get_acc_no();
            }

        },
        methods:{
            add_Client(){
                this.$Progress.start();
                axios.post('/system/client/add',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'multipart/form-data'
                    },
                    body:this.Client
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.$router.push({name:"manage_client"})
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type,
                            text: res.data.message_title
                        });
                        this.Client.no=0;
                        this.Client.rent=0;

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },
            delete_Client(){
                this.Client.delete=true;
                this.update_Client();
            },
            update_Client(){
                this.$Progress.start();
                axios.put('/system/client/'+this.Client.id,{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.Client
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type=='error'?'Deleted':res.data.msg_type,
                            text: res.data.message_title
                        });
                        this.Client.no=0;
                        this.Client.rent=0;
                        this.$router.push({name:"manage_client"})

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },

            get_acc_no(){
                fetch('/system/client/acc_number')
                    .then(res=>res.json())
                    .then(res=>{
                        this.Client.acc_no=res.acc_no;
                    })
            },

            customFilter (item, queryText, itemText) {
                console.log(queryText)



                const textOne = item.name.toLowerCase()
                const textTwo = item.abbr.toLowerCase()
                const searchText = queryText.toLowerCase()

                return textOne.indexOf(searchText) > -1 ||
                    textTwo.indexOf(searchText) > -1
            },


            //for image upload
            pickNID () {
                this.$refs.nid_image.click ()
            },
            pickFile () {
                this.$refs.image.click ()
            },
            picksign () {
                this.$refs.sign_image.click ()
            },

            onFilePicked (e) {
                const files = e.target.files
                if(files[0] !== undefined) {
                    this.imageName = files[0].name
                    if(this.imageName.lastIndexOf('.') <= 0) {
                        return
                    }
                    const fr = new FileReader ()
                    fr.readAsDataURL(files[0])
                    fr.addEventListener('load', () => {
                        this.imageUrl = fr.result
                        this.imageFile = files[0] // this is an image file that can be sent to server...
                        this.Client.profile_pic = fr.result // this is an image file that can be sent to server...
                    })
                } else {
                    this.imageName = ''
                    this.imageFile = ''
                    this.imageUrl = ''
                }
            },
            onNIDPicked (e) {
                const files = e.target.files
                if(files[0] !== undefined) {
                    this.nid.imageName = files[0].name
                    if(this.nid.imageName.lastIndexOf('.') <= 0) {
                        return
                    }
                    const fr = new FileReader ()
                    fr.readAsDataURL(files[0])
                    fr.addEventListener('load', () => {
                        this.nid.imageUrl = fr.result;

                        this.nid.imageFile = files[0] // this is an image file that can be sent to server...
                        this.Client.id_card=fr.result;
                    })
                } else {
                    this.nid.imageName = ''
                    this.nid.imageFile = ''
                    this.nid.imageUrl = ''
                }
            },
            onsignPicked (e) {
                const files = e.target.files
                if(files[0] !== undefined) {
                    this.sign.imageName = files[0].name
                    if(this.sign.imageName.lastIndexOf('.') <= 0) {
                        return
                    }
                    const fr = new FileReader ()
                    fr.readAsDataURL(files[0])
                    fr.addEventListener('load', () => {
                        this.sign.imageUrl = fr.result
                        this.sign.imageFile = files[0] // this is an image file that can be sent to server...
                        this.Client.signature=fr.result;
                    })
                } else {
                    this.sign.imageName = ''
                    this.sign.imageFile = ''
                    this.sign.imageUrl = ''
                }
            }
        }
    }
</script>

<style scoped>

</style>
