import{T as u,o as m,h as i,w as r,d as n,b as t,u as e,n as c}from"./app-3ea472c4.js";import{_}from"./FormSection-4b9f5fdc.js";import{_ as f}from"./PrimaryButton-cbad163b.js";import{_ as d}from"./InputForm-daeecd40.js";import{t as w}from"./toast-523d5346.js";import"./_plugin-vue_export-helper-c27b6911.js";const U={__name:"UpdatePasswordForm",setup(V){const a=u({current_password:"",password:"",password_confirmation:""}),p=()=>{a.put(route("password.update"),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{a.reset(),w.success("Contraseña actualizada correctamente")},onError:l=>{console.log(l)}})};return(l,s)=>(m(),i(_,{onSubmitted:p},{title:r(()=>[n(" Actualizar contraseña ")]),description:r(()=>[n(" Asegúrese que su cuenta este usando una contraseña larga y aleatoria para mantenerse seguro. ")]),form:r(()=>[t(d,{text:"Contraseña actual",modelValue:e(a).current_password,"onUpdate:modelValue":s[0]||(s[0]=o=>e(a).current_password=o),type:"password"},null,8,["modelValue"]),t(d,{text:"Nueva contraseña",name:"password",modelValue:e(a).password,"onUpdate:modelValue":s[1]||(s[1]=o=>e(a).password=o),type:"password"},null,8,["modelValue"]),t(d,{text:"Confirmar contraseña",name:"password_confirmation",modelValue:e(a).password_confirmation,"onUpdate:modelValue":s[2]||(s[2]=o=>e(a).password_confirmation=o),type:"password"},null,8,["modelValue"])]),actions:r(()=>[t(f,{class:c({"opacity-25":e(a).processing}),disabled:e(a).processing},{default:r(()=>[n(" Guardar ")]),_:1},8,["class","disabled"])]),_:1}))}};export{U as default};
