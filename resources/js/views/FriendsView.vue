<template>
    <div class="search">
        <input type="search" v-model="search" placeholder="Поиск друзей">
    </div>
    <div class="block" v-if="load != true && friends.length != 0">
        <div class="card" v-for="(friend, index) in filteredList" :key="friend">
            <div class="header_card" @mouseover="Actions(friend.action, index)"
                @mouseleave="CloseActions(friend.action, index)">
                <svg fill="#606060" width="30px" height="30px" viewBox="0 0 32 32" enable-background="new 0 0 32 32"
                    id="Glyph" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" stroke="#606060">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M16,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S17.654,13,16,13z" id="XMLID_287_">
                        </path>
                        <path d="M6,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S7.654,13,6,13z" id="XMLID_289_">
                        </path>
                        <path d="M26,13c-1.654,0-3,1.346-3,3s1.346,3,3,3s3-1.346,3-3S27.654,13,26,13z" id="XMLID_291_">
                        </path>
                    </g>
                </svg>
                <div class="dropdown_menu" v-if="friend.action == true">
                    <p @click="delete_frined(friend.id_delete)">Удалить</p>
                </div>
            </div>
            <div class="body_card">
                <router-link :to="{ path: '/user/' + friend.id }">
                    <img :src="friend.avatar" alt="">
                    <p>{{ friend.name }} {{ friend.surname }}</p>
                </router-link>
            </div>
        </div>
    </div>
    <div class="none_friends" v-if="load != true && friends.length == 0">
        <p>У вас пока нет друзей</p>
    </div>

    <!-- Loader -->
    <div v-if="load == true" class="block post">
        <div v-for="post in 6" :key="post" class="header_post">
            <div class="curcle_loading"></div>
            <div>
                <div class="text_loading"></div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            friends: [],
            me: [],
            load: false,
            search: ''
        }
    },
    mounted() {
        this.Me();
    },
    computed: {
        filteredList() {
            let sear = this.search
            return this.friends.filter(function (elem) {
                if (sear === '') return true;
                else if (elem.name.indexOf(sear) > -1 != false) {
                    return elem.name.indexOf(sear) > -1;
                }
                else {
                    return elem.surname.indexOf(sear) > -1;
                }
            })
        },
    },
    methods: {
        Me() {
            this.load = true;
            axios.get('/api/me', {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`
                }
            })
                .then(res => {
                    this.me = res.data.content
                    this.my_friends(this.me.id)
                })
        },
        my_friends(id) {
            axios
                .get("/api/my/friend", {
                    headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
                })
                .then((res) => {
                    let arr = res.data.data

                    for (let index = 0; index < arr.length; index++) {
                        if (arr[index].id_user.id != id) {
                            this.friends.push(arr[index].id_user)
                        } else if (arr[index].id_friend.id != id) {
                            this.friends.push(arr[index].id_friend)
                        }
                    }                    

                    this.friends.forEach((friend, index) => {
                        friend.action = false
                        friend.id_delete = arr[index].id
                    })

                    this.load = false
                })
        },
        delete_frined(id) {
            axios.delete(`/api/delete/friend/${id}`, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`
                }
            })
                .then(res => {
                    console.log(res);
                    this.Me()
                })
        },
        Actions(action, index) {
            if (action == false) {
                this.friends[index].action = true;
            }
        },
        CloseActions(action, index) {
            if (action == true) {
                this.friends[index].action = false;
            }
        },
    },
}
</script>

<style lang="scss" scoped>
.post {
    .header_post {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 10px;

        .active_loading {
            background: linear-gradient(110deg, #525252, #474747 18%, #525252);
            border-radius: 5px;
            width: 100%;
            height: 50vh;
            background-size: 200% 100%;
            animation: 1s shine linear infinite;
        }

        .text_loading {
            background: linear-gradient(110deg, #525252, #474747 18%, #525252);
            border-radius: 5px;
            width: 150px;
            height: 20px;
            background-size: 200% 100%;
            animation: 1s shine linear infinite;
        }

        .text_loading:nth-child(2) {
            width: 120px;
            height: 14px;
        }

        .curcle_loading {
            background: linear-gradient(110deg, #525252, #474747 18%, #525252);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            background-size: 200% 100%;
            animation: 1s shine linear infinite;
        }
    }

}

.none_friends {
    width: 100%;
    text-align: center;
    font-size: 26px;
    padding: 50px 0;
    margin-top: 20px;
    border-radius: 10px;
}

@keyframes shine {
    to {
        background-position-x: -200%;
    }
}

.search {
    margin-top: 20px;

    input {
        outline: none;
        width: 100%;
        height: 40px;
        background: transparent;
        border: 2px solid #af3131;
        border-radius: 10px;
        padding-left: 5px;
    }
}

.block {
    display: flex;
    flex-direction: column;
    gap: 30px;

    .card {
        width: 100%;
        position: relative;

        .header_card {
            position: absolute;
            right: -10px;
            top: -25px;

            svg {
                cursor: pointer;
            }
        }

        .dropdown_menu {
            z-index: 10;
            position: absolute;
            display: flex;
            right: -10px;
            top: 0;
            flex-direction: column;
            background: #353535;
            border-radius: 10px;
            align-items: center;
            padding: 15px 0;

            p {
                cursor: pointer;
                width: 100%;
                color: #af3131 !important;
                font-size: 17px !important;
                font-weight: bold;
                border-bottom: 2px solid #606060;
                padding: 0 20px;
                padding-bottom: 10px;
            }

            p:last-child {
                border: none;
                padding-bottom: 0;
            }

            p:first-child {
                padding-top: 0;
            }
        }

        .body_card {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;

            span {
                border: 1px solid white;
                border-radius: 10px;
                padding: 5px 10px;
            }

            a {
                text-decoration: none;
                display: flex;
                flex-direction: row;
                align-items: center;
                gap: 10px;

                img {
                    width: 50px;
                    border-radius: 50%;
                }
            }
        }



    }
}
</style>