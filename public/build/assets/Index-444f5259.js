import{h as k,T as I,o as a,b as v,w as r,d as n,f as u,t as m,a as s,q as V,v as F,u as l,c as x,e as M,k as j,F as z,K as B}from"./app-255317fc.js";import{C as T}from"./Carbon-053ffa43.js";import{_ as A}from"./DialogModal-6c59dca7.js";import{_ as b}from"./PrimaryButton-275c7df4.js";import{_ as E}from"./SecondaryButton-f81cfa04.js";import{c as C,_ as q}from"./AppLayout-0cb1b585.js";import{t as h}from"./toast-44a1761e.js";import{c as G}from"./alert-625697a0.js";import{I as K}from"./IconTrash-3aa68112.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./sweetalert2.all-ba9d370f.js";var L=C("circle-check-filled","IconCircleCheckFilled",[["path",{d:"M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-1.293 5.953a1 1 0 0 0 -1.32 -.083l-.094 .083l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.403 1.403l.083 .094l2 2l.094 .083a1 1 0 0 0 1.226 0l.094 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z","stroke-width":"0",fill:"currentColor",key:"svg-0"}]]),O=C("circle-check","IconCircleCheck",[["path",{d:"M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0",key:"svg-0"}],["path",{d:"M9 12l2 2l4 -4",key:"svg-1"}]]);const U={class:"flex flex-col gap-6"},Y={key:0,class:"text-sm text-red-600 mt-1"},H={class:"max-w-7xl mx-auto sm:px-6 lg:px-8 py-4"},J={class:"flex items-center justify-between mb-6 gap-4"},P=s("div",null,null,-1),Q={class:"grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6"},R={class:"w-full p-6 bg-white shadow-soft-xl rounded-xl"},W={class:"flex flex-col justify-between h-full"},X={class:"flex justify-between"},Z={class:"mb-2"},ee=["onClick"],fe={__name:"Index",props:{notes:{type:Object,required:!0}},setup(g){const c=k(!1),i=k(!0),e=I({id:null,is_done:!1,text:""}),y=[{name:"Dashboard",route:"dashboard.index"},{name:"Notas",route:"dashboard.notes.index"}];function w(t){e.id=t.id,e.text=t.text,i.value=!1,c.value=!0}function N(t){e.id=t.id,e.text=t.text,e.is_done=!0,f()}function $(t){e.id=t.id,e.text=t.text,e.is_done=!1,f()}function S(t){G(()=>{e.delete(route("dashboard.notes.destroy",t),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{h.success("Nota eliminada correctamente!")}})},"¿Estás seguro de eliminar esta nota?")}function D(){i.value?e.post(route("dashboard.notes.store"),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{h.success("Nota creada correctamente!"),p()}}):f()}function f(){e.put(route("dashboard.notes.update",e.id),{preserveScroll:!0,preserveState:!0,onSuccess:()=>{h.success("Nota actualizada correctamente!"),p()}})}function p(){e.reset(),i.value=!0,c.value=!1,B().props.errors={}}return(t,d)=>(a(),v(q,{title:"Dashboard",breads:y},{default:r(()=>[n(A,{show:c.value},{title:r(()=>[u(m(i.value?"Nuevo":"Editar"),1)]),content:r(()=>[s("div",U,[s("div",null,[V(s("textarea",{rows:"4",class:"border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full","onUpdate:modelValue":d[0]||(d[0]=o=>l(e).text=o)},null,512),[[F,l(e).text]]),t.$page.props.errors.text?(a(),x("p",Y,m(t.$page.props.errors.text),1)):M("",!0)])])]),footer:r(()=>[n(E,{onClick:p},{default:r(()=>[u(" Cancelar ")]),_:1}),n(b,{type:"button",onClick:D},{default:r(()=>[u(" Guardar ")]),_:1})]),_:1},8,["show"]),s("div",H,[s("div",J,[P,n(b,{type:"button",onClick:d[1]||(d[1]=o=>c.value=!0)},{default:r(()=>[u(" Nuevo ")]),_:1})]),s("div",Q,[(a(!0),x(z,null,j(g.notes,(o,te)=>(a(),x("div",R,[s("div",W,[s("div",null,[s("div",X,[s("div",Z,m(l(T).create(o.created_at).format("d de F, Y")),1),o.is_done?(a(),v(l(L),{key:1,class:"text-green-500",role:"button",onClick:_=>$(o)},null,8,["onClick"])):(a(),v(l(O),{key:0,onClick:_=>N(o),role:"button"},null,8,["onClick"]))]),s("p",{class:"mb-4 font-normal text-gray-500 mt-2",role:"button",onClick:_=>w(o)},m(o.text),9,ee)]),n(l(K),{onClick:_=>S(o.id),role:"button",size:"20",class:"text-gray-400"},null,8,["onClick"])])]))),256))])])]),_:1}))}};export{fe as default};
