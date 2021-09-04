<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;

class CategoriesArticleSeeder extends Seeder
{
    /**
     * 創建「文章文章類別」並創建文章
     *
     * @return void
     */
    public function run()
    {

        $createData = [
            [
                'categories' => [
                    'name' => 'js',
                ],
                'articles' => [
                    'title' => '滚动加载',
                    'author' => 'Heartless',
                    'thumb' => 'http://blog.heartless.top:3000/public/images/article/1617378698814.jpg',
                    'content' => '## 练习项目时需要实现滚动到指定位置然后加载更多

                    ### 直接放代码吧

                    ```javascript
                    window.onscroll = function(){
                      //scrollTop是滚动条滚动时，距离顶部的距离
                      var scrollTop = document.documentElement.scrollTop||document.body.scrollTop;
                      //windowHeight是可视区的高度
                      var windowHeight = document.documentElement.clientHeight || document.body.clientHeight;
                      //变量scrollHeight是滚动条的总高度
                      var scrollHeight = document.documentElement.scrollHeight||document.body.scrollHeight;
                      //滚动条到底部的条件
                      if(scrollTop+windowHeight == scrollHeight){
                        //到了这个就可以进行业务逻辑加载后台数据了
                        console.log("到了底部");
                        // window.onscroll = "" 用于解除绑定
                      }
                    }
                    ```

                    ### 上面是实现了当滚动条滑到最底部时触发函数，可以根据需求更改条件来触发函数。

                    以上为本人对项目中遇到问题的一些见解，如有错误请指出，感谢您的观看。

                    ',
                ],
                'article_detils' => [
                    'tag' => json_encode(['js']),
                    'description' => '练习项目时需要实现滚动到指定位置然后加载更多',
                    'view' => 124,
                ]
            ],
            [
                'categories' => [
                    'name' => 'vue',
                    'pid' => 1,
                ],
                'articles' => [
                    'title' => '对Vue中兄弟组件通信的思考',
                    'author' => 'Heartless',
                    'thumb' => 'http://blog.heartless.top:3000/../public/images/photos/20210402/1617330367769.jpg',
                    'content' => '关于父子组件的通信，大家都应该很熟悉，用props和$emit就能实现。

                    但兄弟组件间的通信可能不太熟悉，本文将描述一下其实现方法并提出自己的一些思考。

                    ## 订阅发布者模式
                    也可以称为中央事件总线的方式。

                    主要使用$emit和$on，首先新建一个Vue实例bus对象（中央事件总线），然后通过bus.$emit触发事件，bus.$on监听触发的事件。

                    以下代码为在vue-cli中使用

                    ```javaScript
                    //eventBus.js
                    //创建一个空的Vue实例并导出
                    import Vue from "vue"
                    let bus = new Vue();
                    export default bus
                    ```

                    ```js
                    // ComponentA.vue
                    import eventBus from "../eventBus.js"
                    methods: {
                        publish() {
                            //第二个参数为传过去的值
                            eventBus.$emit("event", {count:1, page:2});
                        }
                    }

                    ```
                    ```js
                    // ComponentB.vue
                    import eventBus from "../eventBus.js"
                    data() {
                        return {
                            count: 0
                        }
                    }
                    //要在挂载时监听
                    mounted() {
                        // 这里的this是项目vue实例，用that接受，与eventBus的vue区分
                        let that = this;
                        //第二个参数为一个函数
                        eventBus.$on("event", (val) => {
                            //val为接收的参数对象
                            console.log(val.count) //1
                            //修改data中的数据，注意this的问题
                            that.count = val.count;
                        });
                    }
                    ```

                    以上是在vue-cli中的使用，接下来我想自己模仿实现一下该功能
                    ```js
                    class myEventBus {
                                constructor(){
                                    // { eventType: [ handler1, handler2 ] }
                                    this.subs = {}
                                }
                                // 订阅通知
                                $on(eventType, fn) {
                            //考虑到可以注册同名事件，于是这样写
                                    this.subs[eventType] = this.subs[eventType] || []
                                    this.subs[eventType].push(fn)
                                }
                                // 发布通知
                                $emit(eventType, val) {
                                    if(this.subs[eventType]) {
                                        this.subs[eventType].forEach(v=>v(val))
                                    }
                                }
                            }

                            // 测试
                            var bus = new EventEmitter()

                            // 注册事件
                            bus.$on("click", function (val) {
                                console.log("test",val)  //test 123
                            })

                            bus.$on("click1", function (val) {
                                console.log("test1",val) //test1 {x: 123}
                            })

                            // 触发事件
                            bus.$emit("click", 123);
                            bus.$emit("click1", {x:123});
                    ```
                    以上为本人对项目中遇到问题的一些见解，如有错误请指出，感谢您的观看。

                    ',
                ],
                'article_detils' => [
                    'tag' => json_encode(['组件通信']),
                    'description' => '在Vue项目中经常遇到组件间通信的问题，本文为本人对Vue中兄弟组件间通信的一些思考，订阅-发布模式。',
                    'view' => 278,
                ]

            ],
        ];
        foreach ($createData as $value) {
            Categorie::create($value['categories'])->article()->create($value['articles'])->articleDetil()->create($value['article_detils']);
        }
    }
}
