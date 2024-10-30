name=${1:-"huckabuy-$(date +%Y%m%d-%H%M%S)"}

rm -f huckabuy-2023*.zip

zip -r $name.zip $(ls | grep -v $name)



