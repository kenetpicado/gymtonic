import{T as u,o as m,h as i,w as r,d as n,b as t,u as a,n as c}from"./app-fcae524f.js";import{_ as w}from"./FormSection-6123128b.js";import{_}from"./PrimaryButton-558ab370.js";import{_ as d}from"./InputForm-c85b7645.js";import{t as f}from"./toast-d9d6ba85.js";import"./_plugin-vue_export-helper-c27b6911.js";const S={__name:"UpdatePasswordForm",setup(V){const s=u({current_password:"",password:"",password_confirmation:""}),p=()=>{s.put(route("password.update"),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{s.reset(),f.success("Contrasena actualizada correctamente!!")},onError:l=>{console.log(l)}})};return(l,e)=>(m(),i(w,{onSubmitted:p},{title:r(()=>[n(" Actualizar contrasena ")]),description:r(()=>[n(" Asegurese de que su cuenta este usando una contrasena larga y aleatoria para mantenerse seguro. ")]),form:r(()=>[t(d,{text:"Current Password",modelValue:a(s).current_password,"onUpdate:modelValue":e[0]||(e[0]=o=>a(s).current_password=o),type:"password"},null,8,["modelValue"]),t(d,{text:"New Password",name:"password",modelValue:a(s).password,"onUpdate:modelValue":e[1]||(e[1]=o=>a(s).password=o),type:"password"},null,8,["modelValue"]),t(d,{text:"Confirm Password",name:"password_confirmation",modelValue:a(s).password_confirmation,"onUpdate:modelValue":e[2]||(e[2]=o=>a(s).password_confirmation=o),type:"password"},null,8,["modelValue"])]),actions:r(()=>[t(_,{class:c({"opacity-25":a(s).processing}),disabled:a(s).processing},{default:r(()=>[n(" Guardar ")]),_:1},8,["class","disabled"])]),_:1}))}};export{S as default};