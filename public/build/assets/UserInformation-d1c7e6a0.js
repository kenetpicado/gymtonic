import{g as n}from"./helpers-8a66454b.js";import{o as s,c as o,a as t,u as l,t as r,j as a}from"./app-fcae524f.js";const i={class:"flex gap-3 font-normal text-gray-900 items-center",role:"button"},d={class:"h-10 w-10"},u=["src"],m={class:"text-sm"},y={class:"font-medium text-gray-700 capitalize"},f={key:0,class:"text-gray-400"},h={key:1,class:"text-gray-400 text-xs mt-1"},v={__name:"UserInformation",props:{user:{type:Object,required:!0},type:{type:String,required:!1}},setup(e){const c={"App\\Models\\Employee":"Empleado","App\\Models\\Customer":"Cliente"};return(p,g)=>(s(),o("div",i,[t("div",d,[t("img",{class:"h-full w-full rounded-full object-cover object-center",src:l(n)(e.user.name,e.user.gender),alt:""},null,8,u)]),t("div",m,[t("div",y,r(e.user.name),1),e.user.phone?(s(),o("div",f,r(e.user.phone),1)):a("",!0),e.type?(s(),o("div",h,r(c[e.type]),1)):a("",!0)])]))}};export{v as _};
