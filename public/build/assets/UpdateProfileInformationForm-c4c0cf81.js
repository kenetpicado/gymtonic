import{T as d,o as p,h as f,w as r,d as s,b as l,u as o,n as _}from"./app-3ea472c4.js";import{_ as b}from"./FormSection-4b9f5fdc.js";import{_ as V}from"./PrimaryButton-cbad163b.js";import{_ as i}from"./InputForm-daeecd40.js";import{t as x}from"./toast-523d5346.js";import"./_plugin-vue_export-helper-c27b6911.js";const P={__name:"UpdateProfileInformationForm",props:{user:Object},setup(c){const m=c,e=d({name:m.user.name,email:m.user.email}),u=()=>{e.post(route("dashboard.profile.store"),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{x.success("Perfil actualizado correctamente!!")},onError:n=>{console.log(n)}})};return(n,a)=>(p(),f(b,{onSubmitted:u},{title:r(()=>[s(" Información del perfil ")]),description:r(()=>[s(" Actualizar nombre y correo electrónico. ")]),form:r(()=>[l(i,{text:"Nombre",name:"name",modelValue:o(e).name,"onUpdate:modelValue":a[0]||(a[0]=t=>o(e).name=t)},null,8,["modelValue"]),l(i,{text:"Correo",name:"email",modelValue:o(e).email,"onUpdate:modelValue":a[1]||(a[1]=t=>o(e).email=t)},null,8,["modelValue"])]),actions:r(()=>[l(V,{class:_({"opacity-25":o(e).processing}),disabled:o(e).processing},{default:r(()=>[s(" Guardar ")]),_:1},8,["class","disabled"])]),_:1}))}};export{P as default};