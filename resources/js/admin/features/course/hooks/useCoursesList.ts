import type {Course} from "../types/course";
import {getCoursesList} from "../api/getCoursesList";
import {usePaginatedList} from "../../../shared/hooks/usePaginatedList";

export function useCoursesList() {
    return usePaginatedList<Course>({
        fetcher: getCoursesList
    });
}
