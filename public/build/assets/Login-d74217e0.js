import{o as m,c as d,a,r as p,T as _,b as o,u as s,w as n,F as f,Z as g,t as h,n as b,d as w,e as x}from"./app-93ea45e5.js";import{_ as V}from"./_plugin-vue_export-helper-c27b6911.js";import{_ as $}from"./Checkbox-7b5a305a.js";import{_ as y}from"./PrimaryButton-424b8710.js";import{_ as i}from"./InputForm-f5c87c45.js";const v={},k={class:"min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100"},C={class:"w-full sm:max-w-md p-6 bg-white overflow-hidden rounded-xl"};function N(l,e){return m(),d("div",k,[a("div",C,[p(l.$slots,"default")])])}const S=V(v,[["render",N]]),B={class:"flex flex-col justify-center items-center mb-4"},F=a("img",{src:"/img/logo-ag.png",alt:"",class:"w-16 h-16 mb-4"},null,-1),U={class:"text-lg font-bold"},j=["onSubmit"],q={class:"mt-10"},E={__name:"Login",setup(l){const e=_({email:"",password:"",remember:!1}),c=()=>{e.post(route("login"),{onFinish:()=>e.reset("password")})};return(u,t)=>(m(),d(f,null,[o(s(g),{title:"Ingresar"}),o(S,null,{default:n(()=>[a("div",B,[F,a("h1",U,h(u.$page.props.appName),1)]),a("form",{onSubmit:x(c,["prevent"])},[o(i,{text:"Correo",modelValue:s(e).email,"onUpdate:modelValue":t[0]||(t[0]=r=>s(e).email=r),autofocus:"",required:"",type:"email",autocomplete:"on"},null,8,["modelValue"]),o(i,{text:"Contraseña",modelValue:s(e).password,"onUpdate:modelValue":t[1]||(t[1]=r=>s(e).password=r),required:"",type:"password"},null,8,["modelValue"]),o($,{checked:s(e).remember,"onUpdate:checked":t[2]||(t[2]=r=>s(e).remember=r),text:"Recordarme"},null,8,["checked"]),a("div",q,[o(y,{class:b(["w-full",{"opacity-25":s(e).processing}]),disabled:s(e).processing},{default:n(()=>[w(" Ingresar ")]),_:1},8,["class","disabled"])])],40,j)]),_:1})],64))}};export{E as default};