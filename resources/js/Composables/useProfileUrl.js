export default function useProfileUrl() {
    function get(name) {
        return `https://ui-avatars.com/api/?name=${name}&rounded=true&size=256&background=eef2ff&color=4f46e5`;
    }

    return {
        get,
    };
}
