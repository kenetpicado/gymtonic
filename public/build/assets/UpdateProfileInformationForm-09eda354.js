import{T as d,o as p,h as f,w as a,d as s,b as l,u as o,n as _}from"./app-fcae524f.js";import{_ as V}from"./FormSection-6123128b.js";import{_ as b}from"./PrimaryButton-558ab370.js";import{_ as i}from"./InputForm-c85b7645.js";import{t as x}from"./toast-d9d6ba85.js";import"./_plugin-vue_export-helper-c27b6911.js";const U={__name:"UpdateProfileInformationForm",props:{user:Object},setup(c){const m=c,e=d({name:m.user.name,email:m.user.email}),u=()=>{e.post(route("dashboard.profile.store"),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{x.success("Perfil actualizado correctamente!!")},onError:n=>{console.log(n)}})};return(n,r)=>(p(),f(V,{onSubmitted:u},{title:a(()=>[s(" Informacion del perfil ")]),description:a(()=>[s(" Actualizar nombre y correo electronico. ")]),form:a(()=>[l(i,{text:"Name",modelValue:o(e).name,"onUpdate:modelValue":r[0]||(r[0]=t=>o(e).name=t)},null,8,["modelValue"]),l(i,{text:"Email",modelValue:o(e).email,"onUpdate:modelValue":r[1]||(r[1]=t=>o(e).email=t)},null,8,["modelValue"])]),actions:a(()=>[l(b,{class:_({"opacity-25":o(e).processing}),disabled:o(e).processing},{default:a(()=>[s(" Guardar ")]),_:1},8,["class","disabled"])]),_:1}))}};export{U as default};